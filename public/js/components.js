$(document).ready(function () {
  $('#openModal').click(() => $('#modal').removeClass('hidden'));
  $('#closeModal').click(() => $('#modal').addClass('hidden'));

  $('#openFilter').click(() => $('#filterOverlay').removeClass('hidden'));
  $('#closeFilter').click(() => $('#filterOverlay').addClass('hidden'));
});