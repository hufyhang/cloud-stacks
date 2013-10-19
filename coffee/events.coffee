# events registrator
initEvents = ->
    $('#password').keypress (e) ->
        if e.which is 13
            $('#sign-in-btn').click()

    $("#sign-in-btn").bind 'click', ->
        login = new Login()
        login.login()

    $('#compose-btn').bind 'click', ->
        showCompose ''

    $('#compose-cancel-btn').bind 'click', ->
        closeCompose()

    $('#submit-btn').bind 'click', ->
        msg = new Message window.user
        msg.send()

    $('#in-btn').bind 'click', ->
        msg = new Message window.user
        msg.fetchAll()
        $('#nav').html '-in'

    $('#out-btn').bind 'click', ->
        msg = new Message window.user
        msg.fetchOut()
        $('#nav').html '-out'

    $('#archived-btn').bind 'click', ->
        msg = new Message window.user
        msg.fetchArchived()

    $('#create-btn').bind 'click', ->
        $.post('php/create.php', {username: $('#username').val(), password: hex_md5($('#password').val())}).done (data) ->
            if data is 'OK'
                $('#sign-in-btn').click()
            else
                $('#username').val 'Please choose another username.'

