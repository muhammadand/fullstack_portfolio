---
name: no-browser-alerts
description: Standard rule forbidding native browser confirm/alert dialogs and mandating interactive Tailwind/Alpine.js confirmation modals.
category: frontend
---

# UI Rule: No Native Browser Alerts / Confirms

## Core Principle
**NEVER** use native browser dialogs such as:
- `onsubmit="return confirm('...');"`
- `onclick="return confirm('...');"`
- `window.confirm(...)` or `window.alert(...)`

Native browser popups look outdated, inconsistent across devices/OS, unstyled, and hurt user experience.

## Standard Requirement
Always implement **Interactive Tailwind CSS + Alpine.js Confirmation Modals**:
1. **Trigger Button**:
   - Use a standard `<button type="button" @click="openModal(...)">` instead of inline form submit with alert.
2. **Contextual Detail**:
   - The modal must display relevant identifiers (e.g. ID, Nama, Nominal, Kuantitas).
   - Clear distinction between positive actions (emerald/blue buttons) and destructive actions (red/rose buttons).
3. **Modal Structure**:
   - Ambient dark backdrop (`rgba(15, 23, 42, 0.65)` or `backdrop-blur-sm`).
   - Clean card container with rounded corners (`rounded-2xl` or `rounded-3xl`), header icon, title, description box, warning pill, and action buttons ("Batal" vs "Ya, Lanjutkan").
   - Responsive and accessible on both mobile and desktop screens.
