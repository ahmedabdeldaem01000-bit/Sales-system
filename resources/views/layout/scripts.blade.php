@stack('before-scripts')
<!-- jQuery -->
<script src="{{asset('dashboard/plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('dashboard/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{asset('dashboard/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- ChartJS -->
<script src="{{asset('dashboard/plugins/chart.js/Chart.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{asset('dashboard/plugins/sparklines/sparkline.js')}}"></script>
<!-- JQVMap -->
<script src="{{asset('dashboard/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
<script src="{{asset('dashboard/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{asset('dashboard/plugins/jquery-knob/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{asset('dashboard/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('dashboard/plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('dashboard/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- Summernote -->
<script src="{{asset('dashboard/plugins/summernote/summernote-bs4.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('dashboard/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dashboard/dist/js/adminlte.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('dashboard/dist/js/demo.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{asset('dashboard/dist/js/pages/dashboard.js')}}"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/dayjs/1.11.9/dayjs.min.js"></script>

<script>
    function formatDate(dateString) {
        return dayjs(dateString).format('MMMM D, YYYY h:mm A');
    }

    const formattedDate = formatDate(data.article.created_at);
</script>


<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script>
    Pusher.logToConsole = true;

    var pusher = new Pusher('117e9cb180fd3b91cf23', {
        cluster: 'mt1',
    });

    var channel = pusher.subscribe('my-channel');
    channel.bind('my-event', function(data) {
        updateNotifications(data);
    });

    function updateNotifications(data) {
        const notificationMenu = document.querySelector(
            '.dropdown-menu.dropdown-menu-lg.dropdown-menu-right'
        );

        if (document.querySelector(`[data-id="${data.article.id}"]`)) {
            console.log('الإشعار موجود بالفعل.');
            return;
        }

        const newNotification = `
            <div class="dropdown-divider"></div>
            <a href="${data.article.url}" class="dropdown-item d-flex scrollbar-container" data-id="${data.article.id}">
                <i class="fas fa-envelope mr-2"></i>
                <div class="mr-3">
                    <h3 class="dropdown-item-title">${data.article.title}</h3>
                    <p class="text-sm text-muted">${data.article.author}</p>
                    <span class="float-right text-muted text-sm">${formatDate(data.article.created_at)}</span>
                </div>
            </a>
        `;

        notificationMenu.insertAdjacentHTML('afterbegin', newNotification);

        attachClickListener(data.article.id);

        saveNotification(data);

        const badge = document.querySelector('.navbar-badge');
        const currentCount = parseInt(badge.getAttribute('data-count'), 10) || 0;
        badge.setAttribute('data-count', currentCount + 1);
        badge.textContent = currentCount + 1;
    }

    function saveNotification(data) {
        let notifications = JSON.parse(localStorage.getItem('notifications')) || [];

        if (notifications.some(notification => notification.article.id === data.article.id)) {
            console.log('الإشعار محفوظ مسبقًا.');
            return;
        }

        notifications.push(data);
        localStorage.setItem('notifications', JSON.stringify(notifications));
    }

    function loadNotifications() {
        let notifications = JSON.parse(localStorage.getItem('notifications')) || [];
        notifications.forEach(notification => {
            if (!document.querySelector(`[data-id="${notification.article.id}"]`)) {
                updateNotifications(notification);
            }
        });
    }

    function removeNotificationFromLocalStorage(id) {
        let notifications = JSON.parse(localStorage.getItem('notifications')) || [];
        notifications = notifications.filter(notification => notification.article.id !== id);
        localStorage.setItem('notifications', JSON.stringify(notifications));
    }

    function attachClickListener(id) {
        const notificationElement = document.querySelector(`[data-id="${id}"]`);
        if (notificationElement) {
            notificationElement.addEventListener('click', function() {
                removeNotificationFromLocalStorage(id);

                const badge = document.querySelector('.navbar-badge');
                const currentCount = parseInt(badge.getAttribute('data-count'), 10) || 0;
                badge.setAttribute('data-count', Math.max(currentCount - 1, 0));
                badge.textContent = Math.max(currentCount - 1, 0);
            });
        }
    }

    document.addEventListener('DOMContentLoaded', loadNotifications);
</script>
@stack('scripts-database')
