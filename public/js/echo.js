// Initialize Echo for real-time functionality
window.Echo = new window.Echo({
    broadcaster: 'pusher',
    key: window.pusherKey || null,
    cluster: window.pusherCluster || 'mt1',
    forceTLS: true,
    encrypted: true,
    authEndpoint: '/broadcasting/auth',
    auth: {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
        }
    }
});

// Function to listen for bid updates on a specific auction
function listenForBidUpdates(auctionId) {
    Echo.channel(`auction.${auctionId}`)
        .listen('NewBidPlaced', (e) => {
            // Update the current price on the page
            const priceElement = document.getElementById('current-price');
            if (priceElement) {
                priceElement.textContent = 'Rp ' + e.current_price.toLocaleString('id-ID');
            }

            // Add a notification if it's not the current user's bid
            if (e.bidder !== document.querySelector('meta[name="user-name"]')?.getAttribute('content')) {
                showNotification(`Penawaran baru ditempatkan! Harga saat ini: Rp ${e.current_price.toLocaleString('id-ID')}`);
            }
        });
}

// Function to listen for real-time notifications
function listenForNotifications() {
    const userId = document.querySelector('meta[name="user-id"]')?.getAttribute('content');
    if (userId) {
        Echo.private(`user.${userId}`)
            .listen('NotificationCreated', (e) => {
                // Update the notification count in the header
                updateNotificationCount();

                // Show a real-time notification
                showNotification(e.message);

                // Update the notification dropdown if it exists
                updateNotificationDropdown(e);
            });
    }
}

// Function to update notification count in the header
function updateNotificationCount() {
    // Make an AJAX request to get the unread count
    fetch('/notifications/unread-count')
        .then(response => response.json())
        .then(data => {
            const countElement = document.querySelector('.notification-count');
            const notificationBadge = document.querySelector('[data-notification-badge]');

            if (countElement) {
                countElement.textContent = data.count;
            }

            if (notificationBadge) {
                if (data.count > 0) {
                    notificationBadge.classList.remove('hidden');
                    notificationBadge.textContent = data.count > 99 ? '99+' : data.count;
                } else {
                    notificationBadge.classList.add('hidden');
                }
            }
        })
        .catch(error => console.error('Error fetching notification count:', error));
}

// Function to update the notification dropdown with the new notification
function updateNotificationDropdown(notification) {
    const dropdown = document.querySelector('[x-data*="open"]');
    if (dropdown) {
        // Find the notification list container
        const notificationList = dropdown.querySelector('.max-h-96.overflow-y-auto');
        if (notificationList) {
            // Create a new notification element
            const notificationElement = document.createElement('div');
            notificationElement.className = 'px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors border-b border-gray-50 dark:border-gray-800 last:border-0 opacity-75';
            notificationElement.innerHTML = `
                <p class="text-sm text-text-main font-medium">${notification.message || 'Notifikasi Baru'}</p>
                <p class="text-xs text-text-muted mt-1">${formatTimeAgo(notification.created_at)}</p>
            `;

            // Add the new notification to the top of the list
            notificationList.insertBefore(notificationElement, notificationList.firstChild);

            // Limit to 5 notifications
            const notifications = notificationList.querySelectorAll('[class*="px-4 py-3"]');
            if (notifications.length > 5) {
                notificationList.removeChild(notifications[notifications.length - 1]);
            }
        }
    }
}

// Helper function to format time ago
function formatTimeAgo(dateString) {
    const date = new Date(dateString);
    const now = new Date();
    const diffInSeconds = Math.floor((now - date) / 1000);

    if (diffInSeconds < 60) {
        return 'Baru saja';
    } else if (diffInSeconds < 3600) {
        const minutes = Math.floor(diffInSeconds / 60);
        return `${minutes} menit yang lalu`;
    } else if (diffInSeconds < 86400) {
        const hours = Math.floor(diffInSeconds / 3600);
        return `${hours} jam yang lalu`;
    } else {
        const days = Math.floor(diffInSeconds / 86400);
        return `${days} hari yang lalu`;
    }
}

// Function to show notifications
function showNotification(message) {
    // Create a simple notification element
    const notification = document.createElement('div');
    notification.className = 'fixed top-4 right-4 bg-blue-500 text-white px-4 py-2 rounded shadow-lg z-50 animate-fadeIn';
    notification.textContent = message;

    document.body.appendChild(notification);

    // Remove the notification after 5 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 5000);
}

// Initialize bid listening and notification listening when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // If on an auction detail page, start listening for bid updates
    const auctionIdElement = document.getElementById('auction-id');
    if (auctionIdElement) {
        const auctionId = auctionIdElement.getAttribute('data-auction-id');
        if (auctionId) {
            listenForBidUpdates(auctionId);
        }
    }

    // Start listening for real-time notifications
    listenForNotifications();
});