$(document).ready(function () {
  $('#rentalForm').on('submit', function (e) {
    var startDate = new Date($('input[name="start_date"]').val());
    var endDate = new Date($('input[name="end_date"]').val());

    if (startDate >= endDate) {
      alert("A data final deve ser posterior à data de início.");
      e.preventDefault();
      return false;
    }

    var dailyValue = $('#equipment_select option:selected').data('value');
    var days = (endDate - startDate) / (1000 * 3600 * 24);
    $('#value').val((dailyValue * days).toFixed(2));
  });

  $('#openRentalModal').on('click', function () {
    $('#rentalModal').removeClass('hidden');
  });

  $('#closeRentalModal').on('click', function () {
    $('#rentalModal').addClass('hidden');
  });

  $('#start_date, #end_date').on('change', function () {
    let startDate = $('#start_date').val();
    let endDate = $('#end_date').val();

    if (startDate && endDate) {
      $('#equipmentSelect').removeAttr('disabled');

      $.ajax({
        url: "{{ route('equipments.available') }}",
        type: "GET",
        data: {
          start_date: startDate,
          end_date: endDate
        },
        success: function (data) {
          $('#equipmentSelect').empty();

          data.equipments.forEach(function (equipment) {
            $('#equipmentSelect').append(
              '<option value="' + equipment.id + '">' + equipment.name + '</option>'
            );
          });
        }
      });
    }
  });
});

$(document).on('change', '#start_date, #end_date', function () {
  const start = $('#start_date').val();
  const end = $('#end_date').val();

  if (!start || !end || new Date(start) >= new Date(end)) {
    $('#equipment_id').html('<option>Selecione datas válidas</option>').prop('disabled', true);
    return;
  }

  $.get('/equipments/available', { start_date: start, end_date: end }, function (data) {
    if (data.length === 0) {
      $('#equipment_id').html('<option>Nenhum disponível</option>').prop('disabled', true);
      return;
    }

    const options = data.map(e => `<option value="${e.id}">${e.name}</option>`);
    $('#equipment_id').html(options.join('')).prop('disabled', false);
  });
});

