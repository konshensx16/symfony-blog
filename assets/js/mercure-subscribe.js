const url = new URL('http://localhost:3000/hub');
url.searchParams.append('topic', 'http://symfony-blog.fr/new/article');

const eventSource = new EventSource(url, {withCredentials: true});

// The callback will be called every time an update is published
eventSource.onmessage = e => new newNotification(e);

function newNotification(event) {
    var bell = $('#bell');
    let notificationCenter = $('#notification-center');
    let notification = JSON.parse(event.data);
    let notificationHtml = '<div class="bell-notification-item pb-10 pt-10 pr-20 pl-15">' +
        '                <i class="fa fa-check-circle bell-notification-icon" aria-hidden="true"></i>' +
        '                <span class="bell-notification-content ml-20"><b>Admin</b> a publié un nouvel article</span>' +
        '            </div>';

    if (notificationCenter.hasClass('bell-empty-content')) {
        notificationCenter.removeClass('bell-empty-content').addClass('bell-content');
        notificationCenter.parent().find('span').remove();
    }

    $('.bell-content').append(notificationHtml);
    let count = bell.data('notificationCount');
    count++;
    bell.attr('data-notification-count', count);
}
