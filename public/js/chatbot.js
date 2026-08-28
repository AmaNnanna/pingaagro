/**
 * chatbot.js — Floating Chat Widget
 * Handles open/close toggle for the chat panel.
 * When a provider is chosen, replace the panel body content
 * with their embed script — everything else stays the same.
 */
document.addEventListener('DOMContentLoaded', function () {

    const trigger = document.getElementById('chatTrigger');
    const panel   = document.getElementById('chatPanel');
    const close   = document.getElementById('chatClose');

    if (!trigger || !panel) return;

    // Open the chat panel
    trigger.addEventListener('click', function () {
        panel.classList.add('open');
        trigger.classList.add('hidden');
    });

    // Close the chat panel
    close.addEventListener('click', function () {
        panel.classList.remove('open');
        trigger.classList.remove('hidden');
    });

    // Close on Escape key
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && panel.classList.contains('open')) {
            panel.classList.remove('open');
            trigger.classList.remove('hidden');
        }
    });

});