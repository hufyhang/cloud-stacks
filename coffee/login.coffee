class Login
    constructor: ->
    login: ->
        username = $('#user').val()
        password = $('#password').val()
        password = hex_md5 password
        $.ajax('php/login.php?username=' + username + '&password=' + password).done (data) ->
            if data is 'OK'
                window.user = new User username, password
                $('#welcome-div').html ''
                $('.message-box-div').css 'visibility', 'visible'
                $('#username-title').html '#' + window.user.getName()
                message = new Message window.user
                message.fetchAll()
            else
                $('#username').val 'Invalid username or password'
                $('#password').val ''

