class Message
    constructor: (@user) ->
        @key = 'Cloud-Stacks-Key-CODE'

    decrypt: ->
            $('.message-body').each ->
                $(this).html f23.s52d $(this).html()

    fetchAll: ->
        self = @
        window.currentLoc = 'in'
        $('#in-btn').removeClass().addClass 'active'
        $('#out-btn').removeClass()
        $('#archived-btn').removeClass()
        username = @user.getName()
        $.post("php/fetch.php", {username: username, password: @user.getPassword()}).done (data) ->
            $("#message-div").html data
            self.decrypt()
            $('#in-counter').html $('.message-body').length

    fetchOut: ->
        self = @
        window.currentLoc = 'out'
        $('#out-btn').removeClass().addClass 'active'
        $('#in-btn').removeClass()
        $('#archived-btn').removeClass()
        username = @user.getName()
        $.post("php/fetchOut.php", {username: username, password: @user.getPassword()}).done (data) ->
            $("#message-div").html data
            self.decrypt()

    fetchArchived: ->
        self = @
        window.currentLoc = 'archived'
        $('#archived-btn').removeClass().addClass 'active'
        $('#out-btn').removeClass()
        $('#in-btn').removeClass()
        username = @user.getName()
        $.post("php/fetchArchived.php", {username: username, password: @user.getPassword()}).done (data) ->
            $("#message-div").html data
            self.decrypt()

    send: ->
        self = @
        from = @user.getName()
        to = $('#inputRecipient').val()
        if to is ""
            alert "Oops... You forgot to set the recipients."
            return
        importanceLevel = $('#importance-select').val()
        msg = $('#messageArea').val()
        msg = msg.replace(/&/g, "&amp;").replace(/>/g, "&gt;").replace(/</g, "&lt;").replace(/"/g, "&quot;").replace(/\n/g, '<br/>')
        msg = f23.s52e msg
        now = new Date()
        time = now.getDate() + '/' + (now.getMonth() + 1) + '/' + now.getFullYear() + ' ' + now.getHours() + ':' + now.getMinutes() + ':' + now.getSeconds()
        md5 = hex_md5 time + from + to + msg + importanceLevel
        $.post('php/send.php', {sender: from, recipient: to, importance: importanceLevel, message: msg, md5: md5, timestamp: time }).done (data) ->
            closeCompose()
            self.fetchAll()

