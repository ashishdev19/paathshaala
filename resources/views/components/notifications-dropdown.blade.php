<!-- Notifications Dropdown -->
<div class="relative" x-data="{ open: false, notifications: [], unreadCount: 0 }" x-init="fetchNotifications()" @click.away="open = false">
    <!-- Notification Bell -->
    <button @click="open = !open" 
            class="relative p-2 text-gray-600 hover:text-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 rounded-full">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
        </svg>
        
        <!-- Unread Count Badge -->
        <span x-show="unreadCount > 0" 
              x-text="unreadCount" 
              class="absolute -top-1 -right-1 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-500 rounded-full min-w-[20px] h-5">
        </span>
    </button>

    <!-- Dropdown Panel -->
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute right-0 z-50 mt-2 w-96 bg-white rounded-lg shadow-lg border border-gray-200 max-h-96 overflow-hidden">
        
        <!-- Header -->
        <div class="px-4 py-3 bg-gray-50 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-semibold text-gray-900">Notifications</h3>
                <div class="flex items-center space-x-2">
                    <span x-show="unreadCount > 0" 
                          x-text="`${unreadCount} unread`" 
                          class="text-xs text-gray-500">
                    </span>
                    <button @click="markAllAsRead()" 
                            x-show="unreadCount > 0"
                            class="text-xs text-indigo-600 hover:text-indigo-800 font-medium">
                        Mark all read
                    </button>
                </div>
            </div>
        </div>

        <!-- Notifications List -->
        <div class="max-h-80 overflow-y-auto">
            <template x-for="notification in notifications" :key="notification.id">
                <div class="px-4 py-3 border-b border-gray-100 hover:bg-gray-50 cursor-pointer transition-colors duration-150"
                     :class="{ 'bg-blue-50': !notification.is_read }"
                     @click="handleNotificationClick(notification)">
                    
                    <div class="flex items-start space-x-3">
                        <!-- Icon -->
                        <div class="flex-shrink-0 mt-1">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center"
                                 :class="getNotificationIconBg(notification.type)">
                                <i :class="getNotificationIcon(notification.type)" 
                                   class="text-sm"></i>
                            </div>
                        </div>
                        
                        <!-- Content -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-medium text-gray-900 truncate" 
                                   x-text="notification.title"></p>
                                <div class="flex items-center space-x-1">
                                    <span x-show="!notification.is_read" 
                                          class="w-2 h-2 bg-blue-500 rounded-full"></span>
                                    <span class="text-xs text-gray-500" 
                                          x-text="notification.time_ago"></span>
                                </div>
                            </div>
                            <p class="text-sm text-gray-600 mt-1 line-clamp-2" 
                               x-text="notification.message"></p>
                        </div>
                    </div>
                </div>
            </template>

            <!-- Empty State -->
            <div x-show="notifications.length === 0" 
                 class="px-4 py-8 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No notifications</h3>
                <p class="mt-1 text-sm text-gray-500">You're all caught up!</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="px-4 py-3 bg-gray-50 border-t border-gray-200">
            <a href="{{ route('notifications.index') }}" 
               class="block text-center text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                View all notifications
            </a>
        </div>
    </div>
</div>

<script>
function fetchNotifications() {
    fetch('{{ route("notifications.recent") }}')
        .then(response => response.json())
        .then(data => {
            this.notifications = data.notifications;
            this.unreadCount = data.unread_count;
        })
        .catch(error => {
            console.error('Error fetching notifications:', error);
        });
}

function handleNotificationClick(notification) {
    // Mark as read if unread
    if (!notification.is_read) {
        markAsRead(notification.id);
    }
    
    // Navigate to action URL if available
    if (notification.action_url) {
        window.location.href = notification.action_url;
    }
    
    // Close dropdown
    this.open = false;
}

function markAsRead(notificationId) {
    fetch(`/notifications/${notificationId}/mark-read`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            this.unreadCount = data.unread_count;
            // Update the notification in the array
            const index = this.notifications.findIndex(n => n.id === notificationId);
            if (index !== -1) {
                this.notifications[index].is_read = true;
            }
        }
    })
    .catch(error => {
        console.error('Error marking notification as read:', error);
    });
}

function markAllAsRead() {
    fetch('/notifications/mark-all-read', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            this.unreadCount = 0;
            this.notifications = this.notifications.map(n => ({...n, is_read: true}));
        }
    })
    .catch(error => {
        console.error('Error marking all notifications as read:', error);
    });
}

function getNotificationIcon(type) {
    const icons = {
        'enrollment': 'fas fa-graduation-cap',
        'payment': 'fas fa-credit-card',
        'class_reminder': 'fas fa-clock',
        'certificate': 'fas fa-certificate',
        'course_update': 'fas fa-book',
        'system': 'fas fa-cog'
    };
    return icons[type] || 'fas fa-bell';
}

function getNotificationIconBg(type) {
    const backgrounds = {
        'enrollment': 'bg-blue-100 text-blue-600',
        'payment': 'bg-green-100 text-green-600',
        'class_reminder': 'bg-yellow-100 text-yellow-600',
        'certificate': 'bg-purple-100 text-purple-600',
        'course_update': 'bg-indigo-100 text-indigo-600',
        'system': 'bg-gray-100 text-gray-600'
    };
    return backgrounds[type] || 'bg-blue-100 text-blue-600';
}

// Auto-refresh notifications every 30 seconds
setInterval(() => {
    if (!this.open) {
        fetchNotifications();
    }
}, 30000);
</script>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>