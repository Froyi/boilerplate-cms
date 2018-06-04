$(document).on('click', '.js-news-edit-delete', function (e) {
    if (confirm('Wirklich löschen?') === false) {
        e.preventDefault();
    }
});

$(document).on('click', '.js-news-edit-button', function () {
    let newsId = $(this).data('newsId'),
        $newsEditContainer = $('.js-edit-news-container');

    // noinspection JSUnresolvedVariable
    $.ajax({
        type: 'POST',
        url: 'index.php?route=newsEdit',
        dataType: 'json',
        data: {
            newsId: newsId
        },
        success: function (response) {
            if (response.status === 'success') {
                $newsEditContainer.html(response.view);
                $newsEditContainer.removeClass('invisible');
            }
        }
    })
});