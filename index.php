<?php include './protect/proteksi.php'; ?>
<?php include './component/nav.php'; ?>
<!DOCTYPE html>
<html>
<head>
<title>To Do List</title>
<!-- *Note: You must have internet connection on your laptop or pc other wise below code is not working -->
<!-- CSS for full calender -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css" rel="stylesheet" />
<!-- JS for jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- JS for full calender -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
<!-- bootstrap css and js -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"/>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div id="calendar"></div>
		</div>
	</div>
</div>
<!-- Start popup dialog box -->
<div class="modal fade" id="event_entry_modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalLabel">Add New Event</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">�</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="img-container">
					<div class="row">
						<div class="col-sm-12">  
							<div class="form-group">
							<label for="title">Task Title</label>
							<input type="text" name="title" id="title" class="form-control" placeholder="Enter task title">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">  
							<div class="form-group">
							<label for="deadline">Deadline</label>
							<input type="datetime-local" name="deadline" id="deadline" class="form-control">
							</div>
						</div>
						<div class="col-sm-6">  
							<div class="form-group">
							<label for="reminder">Reminder</label>
							<input type="datetime-local" name="reminder" id="reminder" class="form-control">
							</div>
						</div>
						<div class="col-sm-6">  
							<div class="form-group">
							<label for="priority">Priority</label>
							<select name="priority" id="priority" class="form-control">
							<option value="high">High</option>
							<option value="medium" selected>Medium</option>
							<option value="low">Low</option>
							</select>
							</div>
						</div>
						<div class="col-sm-6">  
							<div class="form-group">
							<label for="category">Category</label>
							<input type="text" name="category" id="category" class="form-control">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" onclick="save_event()">Save Event</button>
			</div>
		</div>
	</div>
</div>

</body>
<script>
$(document).ready(function() {
	display_events();
}); //end document.ready block

function display_events() {
	var events = new Array();
	$.ajax({
  url: 'tasks/display_task.php', // Ganti file
  dataType: 'json',
  success: function (response) {
    var result = response.data;
    $.each(result, function (i, item) {
      events.push({
        event_id: item.event_id,
        title: item.title,
        start: item.start, // deadline
        end: item.end,     // bisa samakan dengan start
        color: item.color,
        url: item.url
      });
    });

    $('#calendar').fullCalendar({
      defaultView: 'month',
      timeZone: 'local',
      events: events,
      select: function (start, end) {
        $('#deadline').val(moment(start).format('YYYY-MM-DDTHH:mm'));
        $('#reminder').val(moment(start).subtract(1, 'hours').format('YYYY-MM-DDTHH:mm')); // contoh default reminder
        $('#event_entry_modal').modal('show');
      },
      eventRender: function (event, element) {
        element.bind('click', function () {
          alert("Task ID: " + event.event_id);
        });
      }
    });
  }
});

}

function save_event() {
  var title = $("#title").val();
  var deadline = $("#deadline").val();
  var reminder = $("#reminder").val();
  var priority = $("#priority").val();
  var category = $("#category").val();

  if (title == "" || deadline == "") {
    alert("Please enter required fields (title and deadline).");
    return false;
  }

  $.ajax({
    url: "tasks/save_task.php", // Ganti file PHP tujuan
    type: "POST",
    dataType: "json",
    data: {
      title: title,
      deadline: deadline,
      reminder: reminder,
      priority: priority,
      category: category,
      // bisa tambahkan user_id jika belum pakai session
    },
    success: function (response) {
      $('#event_entry_modal').modal('hide');
      if (response.status == true) {
        alert(response.msg);
        location.reload();
      } else {
        alert(response.msg);
      }
    },
    error: function (xhr, status) {
      console.log('ajax error = ' + xhr.statusText);
    }
  });

  return false;
}

</script>
</html> 