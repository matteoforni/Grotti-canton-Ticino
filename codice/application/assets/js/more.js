function showMore(btn, id) {
    if ($('#' + id).css('display') === "none") {
        $('#' + btn).html('Read less');
        $('#' + id).css('display', 'inline');
    } else {
        $('#' + btn).html('Read more');
        $('#' + id).css('display', 'none');
    }
}