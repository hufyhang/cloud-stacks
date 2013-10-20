$ ->
    window.user
    window.currentLoc
    initEvents()

window.closeCompose = ->
    $('#inputRecipient').val ''
    $('#messageArea').val ''
    $('.message-compose-div').css 'visibility', 'hidden'

window.showCompose = (_recipient) ->
    $('.message-compose-div').css 'visibility', 'visible'
    $('#inputRecipient').val _recipient
    $('#username').val window.user.getName()

window.archive = (_md5) ->
    $.post 'php/archive.php', {md5: _md5, username: window.user.getName()}
    $('#title-' + _md5).removeClass().addClass 'panel panel-default'
    if window.currentLoc is 'in'
        $('#in-counter').html parseInt($('#in-counter').html())-1
    if window.currentLoc is 'archived'
        $('#in-counter').html parseInt($('#in-counter').html())+1

window.reply = (_sender) ->
    showCompose _sender

