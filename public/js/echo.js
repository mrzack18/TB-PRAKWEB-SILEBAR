// Initialize Echo for real-time functionality (only for bid updates, not notifications)
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
        });
}

// Function to update notification count in the header (only called manually or on page load)
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

// Initialize bid listening when DOM is loaded (notifications are now log-based only)
document.addEventListener('DOMContentLoaded', function() {
    // If on an auction detail page, start listening for bid updates
    const auctionIdElement = document.getElementById('auction-id');
    if (auctionIdElement) {
        const auctionId = auctionIdElement.getAttribute('data-auction-id');
        if (auctionId) {
            listenForBidUpdates(auctionId);
        }
    }

    // Update notification count on page load
    updateNotificationCount();
});