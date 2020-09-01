function getNotifications() {
    startNotificationsLoadingAnimation();
  var xml = new XMLHttpRequest();
  xml.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
        stopNotificationsLoadingAnimation();
        var menu = document.getElementById("notifications-menu");
        var badge = document.getElementById("notifications-badge");
        var response = JSON.parse(this.responseText);
        badge.innerHTML = response.count || 0;
        if(menu.classList.contains("show")) {
            return;
        }
        menu.innerHTML = '';
        for(var i = 0; i < response.notifications.length; i++) {
            menu.innerHTML +=
                "<li>" +
                "<h5>" + response.notifications[i].title + "</h5>" +
                "<p>" + response.notifications[i].description + "</h5>" +
                "</li><hr>\n";
        }
        if(response.notifications.length === 0) {
          menu.innerHTML = "No new notification";
        }
    }
  };
  xml.open("GET", URLROOT + "/notifications", true);
  xml.send();
}

function startNotificationsLoadingAnimation() {
  var badge = document.getElementById("notifications-badge");
  badge.style.display = "none";

  var spinner = document.getElementById("notifications-spinner");
  spinner.style.display = "block";
}

function stopNotificationsLoadingAnimation() {
  var badge = document.getElementById("notifications-badge");
  badge.style.display = "block";

  var spinner = document.getElementById("notifications-spinner");
  spinner.style.display = "none";
}

function readNotifications() {
  var xml = new XMLHttpRequest();
  xml.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
        getNotifications();
    }
  };
  xml.open("GET", URLROOT + "/notifications/read", true);
  xml.send();
}

document.getElementById("notification-icon")
    .addEventListener("click", function() {
        readNotifications();
    });


getNotifications();

setInterval(function() {
    getNotifications();
}, 30000);
