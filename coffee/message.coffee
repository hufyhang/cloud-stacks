class Message
    constructor: (@user) ->
        @key = 'Cloud-Stacks-Key-CODE'
    fetchAll: ->
        window.currentLoc = 'in'
        $('#in-btn').removeClass().addClass 'active'
        $('#out-btn').removeClass()
        $('#archived-btn').removeClass()
        username = @user.getName()
        $.ajax("php/fetch.php?username=" + username).done (data) ->
            $("#message-div").html data
            $('#in-counter').html $('.message-body').length

    fetchOut: ->
        window.currentLoc = 'out'
        $('#out-btn').removeClass().addClass 'active'
        $('#in-btn').removeClass()
        $('#archived-btn').removeClass()
        username = @user.getName()
        $.ajax("php/fetchOut.php?username=" + username).done (data) ->
            $("#message-div").html data

    fetchArchived: ->
        window.currentLoc = 'archived'
        $('#archived-btn').removeClass().addClass 'active'
        $('#out-btn').removeClass()
        $('#in-btn').removeClass()
        username = @user.getName()
        $.ajax("php/fetchArchived.php?username=" + username).done (data) ->
            $("#message-div").html data

    send: ->
        self = @
        from = @user.getName()
        to = $('#inputRecipient').val()
        importanceLevel = $('#importance-select').val()
        msg = $('#messageArea').val()
        now = new Date()
        time = now.getDate() + '/' + (now.getMonth() + 1) + '/' + now.getFullYear() + ' ' + now.getHours() + ':' + now.getMinutes() + ':' + now.getSeconds()
        md5 = hex_md5 time + from + to + msg + importanceLevel
        $.post('php/send.php', {sender: from, recipient: to, importance: importanceLevel, message: msg, md5: md5, timestamp: time }).done (data) ->
            closeCompose()
            self.fetchAll()

