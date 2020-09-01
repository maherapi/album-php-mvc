<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="jumbotron jumbotron-fluid">
  <div class="container">
    <h1 class="display-3"><?= $data['title']; ?></h1>
    <p>This is an album website that allow users to share the photos and categorize them into albums.</p>
    <p><strong>github link: </strong><a href="https://github.com/maherapi/album-php-mvc">Album PHP MVC</a></p>
    <hr>
    <h3>There are two types of users:</h3>
    <ul>
      <li>
        <strong>normal user:</strong>
        can use the website to upload images, create albums, and browse others' albums and images.
      </li>
      <li>
        <strong>admins:</strong>
        can monitor and manage the users of the website, activate them (every new user register need to be activated, the admin will recieve a notification)
      </li>
    </ul>

    <br><br>

    <h3>example accounts:</h3>
    <ul>
      <li>
        <h5>admin:</h5>
        <ul>
          <li><strong>email:</strong>maher@maher.com</li>
          <li><strong>password:</strong>11111111</li>
        </ul>
      </li>
      <br>
      <li>
        <h5>normal user:</h5>
        <ul>
          <li><strong>email:</strong>someaccount@mail.com</li>
          <li><strong>password:</strong>11111111</li>
        </ul>
      </li>
    </ul>
  </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>