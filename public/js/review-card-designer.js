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

    // Support parameter URL ?template=portrait_standee
    var urlParams = new URLSearchParams(window.location.search);
    var urlTpl = urlParams.get("template");
    var defaultTpl = (urlTpl === "portrait_standee" || urlTpl === "standee_portrait") ? "portrait_standee" : "square_nfc";

    return {
        // ── State ──
        isGenerating: false,
        generatingType: "",
        statusMessage: "",
        statusType: "info",
        selectedTemplate: defaultTpl,

        // ── Config dari data-* ──
        scanUrl: ds.scanUrl || "",
        serialNumber: ds.serial || "",
        exportUrl: ds.exportUrl || "",
        csrfToken: ds.csrf || "",

        // Ukuran PDF (mm)
        pdfWidthMm: { square_nfc: 110, portrait_standee: 100 },

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
            return this.selectedTemplate === "square_nfc"
                ? "Square-Google"
                : "Standee-Portrait";
        },

        // ── Generate QR Codes (client-side, high-res) ──
        generateQR: function () {
            var url = this.scanUrl;
            ["localQrSquare", "localQrPortrait"].forEach(function (id) {
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
            return this.selectedTemplate === "square_nfc"
                ? document.getElementById("cardSquareNfc")
                : document.getElementById("cardPortraitStandee");
        },

        // ══════════════════════════════════════════════
        //  CAPTURE: Clone kartu ke offscreen → html2canvas
        // ══════════════════════════════════════════════
        captureToCanvas: function (element, bgColor) {
            var rect = element.getBoundingClientRect();
            var w = Math.round(rect.width);
            var h = Math.round(rect.height);
            if (!w || !h) {
                return Promise.reject(new Error("Ukuran kartu 0. Refresh halaman."));
            }

            // Buat wrapper offscreen
            var wrapper = document.createElement("div");
            wrapper.style.cssText =
                "position:fixed;left:0;top:0;z-index:-9999;pointer-events:none;overflow:hidden;" +
                "width:" + w + "px;height:" + h + "px";

            // Clone elemen — hilangkan ID ganda, reset transform
            var clone = element.cloneNode(true);
            clone.removeAttribute("id");
            clone.style.cssText =
                "position:relative;left:0;top:0;margin:0;transform:none;" +
                "box-shadow:none;visibility:visible;opacity:1;" +
                "width:" + w + "px;height:" + h + "px";

            // Bersihkan SEMUA box-shadow dan filter di elemen anak agar html2canvas tidak membuat artefak kotak abu-abu
            var subEls = clone.querySelectorAll("*");
            for (var i = 0; i < subEls.length; i++) {
                subEls[i].style.boxShadow = "none";
                subEls[i].style.filter = "none";
                subEls[i].style.webkitFilter = "none";
            }

            wrapper.appendChild(clone);
            document.body.appendChild(wrapper);

            // Hitung scale optimal (max 4x, limit 16MP canvas utk mobile)
            var maxPx = 16000000;
            var scale = Math.min(4, Math.sqrt(maxPx / (w * h)));

            function doRender(s) {
                return html2canvas(clone, {
                    scale: s,
                    useCORS: true,
                    allowTaint: false,
                    backgroundColor: bgColor || null,
                    scrollX: 0,
                    scrollY: 0,
                    x: 0,
                    y: 0,
                    width: w,
                    height: h,
                    logging: false,
                });
            }

            // Tunggu 2 frame agar browser layout clone
            return new Promise(function (ok) {
                requestAnimationFrame(function () {
                    requestAnimationFrame(ok);
                });
            })
                .then(function () {
                    return doRender(scale);
                })
                .catch(function () {
                    // Fallback scale lebih rendah jika gagal (memory limit mobile)
                    return doRender(2);
                })
                .finally(function () {
                    if (document.body.contains(wrapper)) {
                        document.body.removeChild(wrapper);
                    }
                });
        },

        // ══════════════════════════════════════════════
        //  DOWNLOAD: Kirim data ke server via <form POST>
        //  Server merespons Content-Disposition: attachment
        //  → Browser PASTI simpan dengan nama file + ekstensi yang benar.
        //  Tidak ada lagi file UUID tanpa ekstensi.
        // ══════════════════════════════════════════════
        sendToServer: function (dataUrl, filename, fileType) {
            // Jika export endpoint tersedia → kirim via form POST
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

            // Fallback: client-side <a download>
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
                    var dataUrl = canvas.toDataURL("image/png", 1.0);
                    var name =
                        "Google-Review-" +
                        self.templateLabel +
                        "-" +
                        self.safeSerial +
                        "-HD.png";
                    self.sendToServer(dataUrl, name, "png");
                    self.setStatus("PNG berhasil di-download! ✅", "info", 4000);
                })
                .catch(function (err) {
                    console.error("PNG error:", err);
                    self.setStatus(
                        "Gagal: " + (err.message || "Coba lagi."),
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

                    var name =
                        "Google-Review-" +
                        self.templateLabel +
                        "-" +
                        self.safeSerial +
                        "-PrintReady.pdf";
                    var pdfUri = pdf.output("datauristring");
                    self.sendToServer(pdfUri, name, "pdf");
                    self.setStatus("PDF berhasil di-download! ✅", "info", 4000);
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
                tempDiv.style.cssText = "position:fixed;left:-9999px;top:-9999px;";
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
                    var dataUrl = "";
                    if (canvas) {
                        dataUrl = canvas.toDataURL("image/png");
                    } else {
                        var img = tempDiv.querySelector("img");
                        if (img) dataUrl = img.src;
                    }

                    if (document.body.contains(tempDiv)) {
                        document.body.removeChild(tempDiv);
                    }

                    if (dataUrl) {
                        var name = "Google-Review-QRCode-" + self.safeSerial + "-1024px.png";
                        self.sendToServer(dataUrl, name, "png");
                        self.setStatus("QR Code berhasil di-download! ✅", "info", 4000);
                    } else {
                        self.setStatus("Gagal membuat QR Code.", "error", 4000);
                    }
                    self.isGenerating = false;
                    self.generatingType = "";
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
