$ ->
    window.user
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
    $.post 'php/archive.php', {md5: _md5}
    $('#title-' + _md5).removeClass().addClass 'panel panel-default'

window.reply = (_sender) ->
    showCompose _sender

