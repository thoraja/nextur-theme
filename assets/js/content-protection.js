/**
 * Content Protection Script
 * Disables Right-Click, Copy/Paste, and Dragging
 */
document.addEventListener('DOMContentLoaded', function() {
    
    // 1. Disable Right Click (Context Menu)
    document.addEventListener('contextmenu', function(e) {
        e.preventDefault();
    });

    // 2. Disable Copy, Cut, Paste
    const events = ['copy', 'cut', 'paste'];
    events.forEach(function(event) {
        document.addEventListener(event, function(e) {
            e.preventDefault();
        });
    });

    // 3. Disable Dragging (Images/Text)
    document.addEventListener('dragstart', function(e) {
        e.preventDefault();
    });

    // 4. Disable Keyboard Shortcuts (Ctrl+C, Ctrl+V, Ctrl+U, Ctrl+S, etc.)
    document.addEventListener('keydown', function(e) {
        // Mac uses Meta (Command), Windows/Linux uses Ctrl
        if (e.ctrlKey || e.metaKey) {
            var key = e.key.toLowerCase();
            // Prevent: C (Copy), V (Paste), X (Cut), S (Save), U (View Source), P (Print)
            if (key === 'c' || key === 'v' || key === 'x' || key === 's' || key === 'u' || key === 'p') {
                e.preventDefault();
            }
        }
        
        // Prevent F12 (DevTools) - Optional, can be bypassed easily but deters casual users
        if (e.key === 'F12') {
            e.preventDefault();
        }
    });

});
