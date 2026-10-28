/**
 * Review Card Designer — External JS Module
 * File ini MURNI JavaScript, tidak ada PHP/Blade.
 * Semua config dibaca dari HTML data-* attributes di #cardConfig.
 *
 * Dependencies (load via CDN sebelum file ini):
 *  - QRCode.js (qrcodejs)
 *  - html2canvas
 *  - jsPDF
 */

function partnerCardDesigner() {
    // Baca config dari hidden div di HTML
    var cfg = document.getElementById("cardConfig");
    var ds = cfg ? cfg.dataset : {};

    // Support parameter URL ?template=...
    var urlParams = new URLSearchParams(window.location.search);
    var urlTpl = urlParams.get("template");
    var validTemplates = ["square", "square_nfc", "portrait_standee"];
    var defaultTpl = validTemplates.indexOf(urlTpl) !== -1 ? urlTpl : "square";

    return {
        // ── State ──
        isGenerating: false,
        generatingType: "",
        statusMessage: "",
        statusType: "info",
        selectedTemplate: defaultTpl,
        templatesList: validTemplates,

        // ── Config dari data-* ──
        scanUrl: ds.scanUrl || "",
        serialNumber: ds.serial || "",
        exportUrl: ds.exportUrl || "",
        csrfToken: ds.csrf || "",

        // Ukuran PDF (mm)
        pdfWidthMm: { square: 110, square_nfc: 110, portrait_standee: 100 },

        // ── Init ──
        init: function () {
            this.generateQR();
        },

        // ── Switch Template & Re-generate QR ──
        setTemplate: function (tpl) {
            this.selectedTemplate = tpl;
            var self = this;
            setTimeout(function () {
                self.generateQR();
            }, 60);
        },

        // ── Swap Template (Next & Prev for Card Carousel) ──
        nextTemplate: function () {
            var idx = this.templatesList.indexOf(this.selectedTemplate);
            var nextIdx = (idx + 1) % this.templatesList.length;
            this.setTemplate(this.templatesList[nextIdx]);
        },
        prevTemplate: function () {
            var idx = this.templatesList.indexOf(this.selectedTemplate);
            var prevIdx = (idx - 1 + this.templatesList.length) % this.templatesList.length;
            this.setTemplate(this.templatesList[prevIdx]);
        },

        // ── Status Banner ──
        setStatus: function (msg, type, clearMs) {
            this.statusMessage = msg;
            this.statusType = type || "info";
            if (clearMs && clearMs > 0) {
                var self = this;
                setTimeout(function () {
                    self.statusMessage = "";
                }, clearMs);
            }
        },

        // ── Computed Helpers ──
        get safeSerial() {
            return String(this.serialNumber).replace(/[^a-zA-Z0-9_\-]+/g, "-");
        },
        get templateLabel() {
            if (this.selectedTemplate === "square") return "Square-QR";
            if (this.selectedTemplate === "square_nfc") return "Square-NFC";
            return "Standee-Portrait";
        },

        // ── Generate QR Codes (client-side, high-res) ──
        generateQR: function () {
            var url = this.scanUrl;
            ["localQrSquare", "localQrSquareNfc", "localQrPortrait"].forEach(function (id) {
                var container = document.getElementById(id);
                if (!container) return;
                container.innerHTML = "";
                new QRCode(container, {
                    text: url,
                    width: 600,
                    height: 600,
                    colorDark: "#000000",
                    colorLight: "#ffffff",
                    correctLevel: QRCode.CorrectLevel.H,
                });
                // Stretch QR ke full container
                setTimeout(function () {
                    var el =
                        container.querySelector("img") ||
                        container.querySelector("canvas");
                    if (el) {
                        el.style.width = "100%";
                        el.style.height = "100%";
                        el.style.objectFit = "contain";
                        el.style.display = "block";
                    }
                }, 100);
            });
        },

        // ── Ambil elemen kartu aktif ──
        getCard: function () {
            if (this.selectedTemplate === "square") {
                return document.getElementById("cardSquare");
            }
            if (this.selectedTemplate === "square_nfc") {
                return document.getElementById("cardSquareNfc");
            }
            return document.getElementById("cardPortraitStandee");
        },


        captureToCanvas: function (element, bgColor) {
            var rect = element.getBoundingClientRect();
            var w = Math.round(rect.width);
            var h = Math.round(rect.height);
            if (!w || !h) {
                return Promise.reject(new Error("Ukuran kartu 0. Refresh halaman."));
            }

            var fontPromise = (document.fonts && document.fonts.ready)
                ? document.fonts.ready
                : Promise.resolve();

            function fallbackRender() {
                var maxPx = 16000000;
                var scale = Math.min(4, Math.sqrt(maxPx / (w * h)));

                return html2canvas(element, {
                    scale: scale,
                    useCORS: true,
                    allowTaint: false,
                    backgroundColor: bgColor || null,
                    scrollX: 0,
                    scrollY: 0,
                    logging: false,
                    onclone: function (clonedDoc) {
                        var cardId = element.id;
                        var clonedCard = cardId ? clonedDoc.getElementById(cardId) : null;
                        if (!clonedCard) return;

                        var subEls = clonedCard.querySelectorAll("*");
                        for (var i = 0; i < subEls.length; i++) {
                            subEls[i].style.boxShadow = "none";
                            subEls[i].style.filter = "none";
                            subEls[i].style.webkitFilter = "none";
                        }
                        clonedCard.style.boxShadow = "none";
                        clonedCard.style.filter = "none";
                        clonedCard.style.transform = "none";
                    },
                });
            }

            // 1. Prioritas: html-to-image (SVG ForeignObject)
            // Menggunakan engine rendering browser asli, semua flexbox, margin, line-height 100% presisi
            if (window.htmlToImage && typeof window.htmlToImage.toCanvas === "function") {
                return fontPromise
                    .then(function () {
                        return new Promise(function (ok) {
                            requestAnimationFrame(function () {
                                requestAnimationFrame(ok);
                            });
                        });
                    })
                    .then(function () {
                        return window.htmlToImage.toCanvas(element, {
                            pixelRatio: 3, // Ultra-HD 3x resolusi untuk cetak tajam
                            backgroundColor: bgColor || null,
                            cacheBust: true,
                            style: {
                                boxShadow: "none",
                                transform: "none",
                                margin: "0",
                            },
                        });
                    })
                    .catch(function (err) {
                        console.warn("htmlToImage fallback:", err);
                        return fallbackRender();
                    });
            }

            // 2. Fallback: html2canvas
            return fontPromise
                .then(function () {
                    return new Promise(function (ok) {
                        requestAnimationFrame(function () {
                            requestAnimationFrame(ok);
                        });
                    });
                })
                .then(function () {
                    return fallbackRender();
                });
        },

        // Deteksi in-app browser (WhatsApp, Instagram, dsb)
        isInAppBrowser: function () {
            var ua = navigator.userAgent || navigator.vendor || (window.opera ? window.opera : "");
            return /FBAN|FBAV|Instagram|WhatsApp|Line\/|Snapchat/i.test(ua);
        },

        // ══════════════════════════════════════════════
        //  UNIVERSAL DOWNLOAD & SHARE (Android, iPhone & Desktop)
        // ══════════════════════════════════════════════
        saveOrShareFile: function (blob, filename, mimeType) {
            var self = this;
            var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
            var file = null;

            try {
                file = new File([blob], filename, { type: mimeType });
            } catch (e) {
                file = null;
            }

            // 1. Mobile (iPhone / Android) dengan Web Share API yang mendukung file
            // Ini solusi paling aman & native di smartphone:
            // - Di iPhone: Membuka menu native iOS -> "Simpan ke File", "Kirim ke WhatsApp", "AirDrop"
            // - Di Android: Membuka Share Sheet -> Simpan ke Google Files / WhatsApp / Download
            if (isMobile && file && navigator.canShare && navigator.canShare({ files: [file] })) {
                return navigator.share({
                    files: [file],
                    title: filename,
                }).then(function () {
                    self.setStatus("File berhasil disimpan / dibagikan! ✅", "info", 4000);
                }).catch(function (shareErr) {
                    if (shareErr && (shareErr.name === "AbortError" || shareErr.code === 20)) {
                        // User menutup share sheet (bukan error teknis)
                        self.setStatus("Penyimpanan dibatalkan oleh pengguna.", "info", 2500);
                        return;
                    }
                    // Jika share gagal, coba fallback langsung ke trigger download
                    self.triggerBlobDownload(blob, filename);
                });
            }

            // 2. Desktop atau browser standar (Chrome, Safari PC, Edge, Firefox)
            this.triggerBlobDownload(blob, filename);
            return Promise.resolve();
        },

        triggerBlobDownload: function (blob, filename) {
            var self = this;
            try {
                var blobUrl = URL.createObjectURL(blob);
                var link = document.createElement("a");
                link.href = blobUrl;
                link.download = filename;
                link.style.display = "none";
                document.body.appendChild(link);
                link.click();

                setTimeout(function () {
                    if (document.body.contains(link)) document.body.removeChild(link);
                    URL.revokeObjectURL(blobUrl);
                    self.setStatus("Download berhasil dimulai! Periksa folder Download / File Anda. ✅", "info", 4000);
                }, 1200);
            } catch (e) {
                console.warn("Direct blob download gagal, mencoba fallback dataURI:", e);
                // Fallback terakhir: buka blob di tab baru
                var url = URL.createObjectURL(blob);
                window.open(url, "_blank");
                self.setStatus("File dibuka di tab baru. Silakan simpan / unduh.", "info", 4000);
            }
        },

        // Fallback server POST bila diperlukan
        sendToServer: function (dataUrl, filename, fileType) {
            if (this.exportUrl && this.csrfToken) {
                var form = document.createElement("form");
                form.method = "POST";
                form.action = this.exportUrl;
                form.style.display = "none";

                var fields = {
                    _token: this.csrfToken,
                    file_data: dataUrl,
                    filename: filename,
                    file_type: fileType || "png",
                };

                for (var key in fields) {
                    var inp = document.createElement("input");
                    inp.type = "hidden";
                    inp.name = key;
                    inp.value = fields[key];
                    form.appendChild(inp);
                }

                document.body.appendChild(form);
                form.submit();

                setTimeout(function () {
                    if (document.body.contains(form)) document.body.removeChild(form);
                }, 3000);
                return;
            }

            var a = document.createElement("a");
            a.href = dataUrl;
            a.download = filename;
            document.body.appendChild(a);
            a.click();
            setTimeout(function () {
                if (document.body.contains(a)) document.body.removeChild(a);
            }, 1000);
        },

        // ══════════════════════════════════════════════
        //  DOWNLOAD PNG — Resolusi Tinggi (≈300+ DPI)
        // ══════════════════════════════════════════════
        downloadPNG: function () {
            if (this.isGenerating) return;
            var card = this.getCard();
            if (!card) {
                this.setStatus("Kartu tidak ditemukan.", "error", 4000);
                return;
            }

            this.isGenerating = true;
            this.generatingType = "png";
            this.setStatus("Membuat gambar PNG resolusi tinggi...");

            var self = this;
            this.captureToCanvas(card, null)
                .then(function (canvas) {
                    var filename =
                        "Google-Review-" +
                        self.templateLabel +
                        "-" +
                        self.safeSerial +
                        "-HD.png";

                    if (canvas.toBlob) {
                        canvas.toBlob(function (blob) {
                            if (!blob) {
                                self.setStatus("Gagal membuat gambar PNG.", "error", 4000);
                                self.isGenerating = false;
                                self.generatingType = "";
                                return;
                            }
                            self.saveOrShareFile(blob, filename, "image/png")
                                .finally(function () {
                                    self.isGenerating = false;
                                    self.generatingType = "";
                                });
                        }, "image/png");
                    } else {
                        var dataUrl = canvas.toDataURL("image/png", 1.0);
                        self.sendToServer(dataUrl, filename, "png");
                        self.setStatus("PNG berhasil di-download! ✅", "info", 4000);
                        self.isGenerating = false;
                        self.generatingType = "";
                    }
                })
                .catch(function (err) {
                    console.error("PNG error:", err);
                    self.setStatus(
                        "Gagal: " + (err.message || "Coba lagi."),
                        "error",
                        6000,
                    );
                    self.isGenerating = false;
                    self.generatingType = "";
                });
        },

        // ══════════════════════════════════════════════
        //  DOWNLOAD PDF — Siap Cetak, Rasio Presisi
        // ══════════════════════════════════════════════
        downloadPDF: function () {
            if (this.isGenerating) return;
            var card = this.getCard();
            if (!card) {
                this.setStatus("Kartu tidak ditemukan.", "error", 4000);
                return;
            }

            this.isGenerating = true;
            this.generatingType = "pdf";
            this.setStatus("Menyusun dokumen PDF siap cetak...");

            var self = this;
            this.captureToCanvas(card, "#ffffff")
                .then(function (canvas) {
                    var imgData = canvas.toDataURL("image/png", 1.0);
                    var pdfW = self.pdfWidthMm[self.selectedTemplate] || 100;
                    var pdfH = +(pdfW * (canvas.height / canvas.width)).toFixed(2);

                    var jsPDF = window.jspdf.jsPDF;
                    var pdf = new jsPDF({
                        orientation: pdfH >= pdfW ? "portrait" : "landscape",
                        unit: "mm",
                        format: [pdfW, pdfH],
                        compress: true,
                    });
                    pdf.addImage(imgData, "PNG", 0, 0, pdfW, pdfH, undefined, "FAST");

                    var filename =
                        "Google-Review-" +
                        self.templateLabel +
                        "-" +
                        self.safeSerial +
                        "-PrintReady.pdf";

                    var pdfBlob = pdf.output("blob");
                    return self.saveOrShareFile(pdfBlob, filename, "application/pdf");
                })
                .catch(function (err) {
                    console.error("PDF error:", err);
                    self.setStatus(
                        "Gagal PDF: " + (err.message || "Coba lagi."),
                        "error",
                        6000,
                    );
                })
                .finally(function () {
                    self.isGenerating = false;
                    self.generatingType = "";
                });
        },

        // ══════════════════════════════════════════════
        //  DOWNLOAD HANYA QR CODE — PNG Ultra HD (1024x1024)
        // ══════════════════════════════════════════════
        downloadQR: function () {
            if (this.isGenerating) return;
            this.isGenerating = true;
            this.generatingType = "qr";
            this.setStatus("Membuat file QR Code Ultra-HD (1024px)...");

            var self = this;
            try {
                var tempDiv = document.createElement("div");
                tempDiv.style.cssText = "position:fixed;left:-9999px;top:-9999px;width:0;height:0;overflow:hidden;opacity:0;pointer-events:none;";
                document.body.appendChild(tempDiv);

                new QRCode(tempDiv, {
                    text: self.scanUrl,
                    width: 1024,
                    height: 1024,
                    colorDark: "#000000",
                    colorLight: "#ffffff",
                    correctLevel: QRCode.CorrectLevel.H,
                });

                setTimeout(function () {
                    var canvas = tempDiv.querySelector("canvas");
                    var filename = "Google-Review-QRCode-" + self.safeSerial + "-1024px.png";

                    if (canvas && canvas.toBlob) {
                        canvas.toBlob(function (blob) {
                            if (document.body.contains(tempDiv)) {
                                document.body.removeChild(tempDiv);
                            }
                            if (blob) {
                                self.saveOrShareFile(blob, filename, "image/png");
                            } else {
                                self.setStatus("Gagal membuat QR Code.", "error", 4000);
                            }
                            self.isGenerating = false;
                            self.generatingType = "";
                        }, "image/png");
                    } else {
                        var img = tempDiv.querySelector("img");
                        var dataUrl = canvas ? canvas.toDataURL("image/png") : (img ? img.src : "");
                        if (document.body.contains(tempDiv)) {
                            document.body.removeChild(tempDiv);
                        }
                        if (dataUrl) {
                            self.sendToServer(dataUrl, filename, "png");
                            self.setStatus("QR Code berhasil di-download! ✅", "info", 4000);
                        } else {
                            self.setStatus("Gagal membuat QR Code.", "error", 4000);
                        }
                        self.isGenerating = false;
                        self.generatingType = "";
                    }
                }, 150);
            } catch (err) {
                console.error("QR download error:", err);
                self.setStatus("Gagal download QR: " + (err.message || ""), "error", 5000);
                self.isGenerating = false;
                self.generatingType = "";
            }
        },
    };
}
