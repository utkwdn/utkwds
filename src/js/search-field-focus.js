/**
 * After the bootstrap collapse animation is complete on the search field, focus on the search field.
 */
$(document).on('shown.bs.collapse', '.search-form', function () {
  $('.search-form input[type="search"]').focus();
});
