const url = new URL('http://localhost:3000/hub');
url.searchParams.append('topic', 'http://symfony-blog.fr/new/article');

const eventSource = new EventSource(url, {withCredentials: true});

// The callback will be called every time an update is published
eventSource.onmessage = e => new newNotification(e); // do something with the payload

function newNotification(event) {
    let notification = JSON.parse(event.data);

    console.log(document.querySelector('.bell-body').classList);
    console.log(notification.createdBy.username)
}
