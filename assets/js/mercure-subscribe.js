const url = new URL('http://localhost:3000/hub');
url.searchParams.append('topic', 'http://symfony-blog.fr/new/article');

const eventSource = new EventSource(url, {withCredentials: true});

// The callback will be called every time an update is published
eventSource.onmessage = e => new newNotification(e); // do something with the payload

function newNotification(event) {
    let notification = JSON.parse(event.data);

    $('.bell-body>.no-notification').remove();
    $('.bell-body').append('<div class="bell-notification-item pb-10 pt-10 pr-20 pl-15">' +
        '                <i class="fa fa-check-circle bell-notification-icon" aria-hidden="true"></i>' +
        '                <span class="bell-notification-content ml-20"><b>Admin</b> a publié un nouvel article</span>' +
        '            </div>');
    console.log(notification.createdBy.username)
}
