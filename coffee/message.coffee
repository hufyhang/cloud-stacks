class Message
    constructor: (@user) ->
        @key = 'Cloud-Stacks-Key-CODE'
    fetchAll: ->
        username = @user.getName()
        $.ajax("php/fetch.php?username=" + username).done (data) ->
            $("#message-div").html data
            $('#username-title').html '#' + window.user.getName() + ' -in'

    fetchOut: ->
        username = @user.getName()
        $.ajax("php/fetchOut.php?username=" + username).done (data) ->
            $("#message-div").html data
            $('#username-title').html '#' + window.user.getName() + ' -out'

    fetchArchived: ->
        username = @user.getName()
        $.ajax("php/fetchArchived.php?username=" + username).done (data) ->
            $("#message-div").html data
            $('#username-title').html '#' + window.user.getName() + ' -archived'

    send: ->
        self = @
        from = @user.getName()
        to = $('#inputRecipient').val()
        importanceLevel = $('#importance-select').val()
        # msg = sjcl.encrypt @key, $('#messageArea').val()
        msg = $('#messageArea').val()
        now = new Date()
        time = now.getDate() + '/' + (now.getMonth() + 1) + '/' + now.getFullYear() + ' ' + now.getHours() + ':' + now.getMinutes() + ':' + now.getSeconds()
        md5 = hex_md5 time + from + to + msg + importanceLevel
        $.post('php/send.php', {sender: from, recipient: to, importance: importanceLevel, message: msg, md5: md5, timestamp: time }).done (data) ->
            closeCompose()
            self.fetchAll()

