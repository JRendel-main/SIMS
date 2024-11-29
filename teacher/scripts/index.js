$(document).ready(() => {
    $.ajax({
        url: 'controllers/getTeacherInfo.php',
        type: 'GET',
        success: (data) => {
            data = JSON.parse(data);
            console.log(data);
        }
    });

    // initialize calendar
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        navLinks: true,
        selectable: true,
        selectMirror: true,
        DragEvent: true,
        select: function (arg) {
            // use sweetalert2 to add event, include subject, start, duration of schedule
            swal.fire({
                title: 'Add Schedule',
                html: '<input id="swal-input1" class="swal2-input" placeholder="Subject">' +
                    '<input id="swal-input2" class="swal2-input" placeholder="Start" type="date">' +
                    '<input id="swal-input3" class="swal2-input" placeholder="Duration" type="number">',
                focusConfirm: false,
                preConfirm: () => {
                    return [
                        document.getElementById('swal-input1').value,
                        document.getElementById('swal-input2').value,
                        document.getElementById('swal-input3').value
                    ]
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    var title = result.value[0];
                    var start = result.value[1];
                    var duration = result.value[2];
                    calendar.addEvent({
                        title: title,
                        start: start,
                        end: duration
                    });
                    console.log(title, start, duration);
                }

            })
        },
        eventClick: function (info) {
            info.jsEvent.preventDefault();
            swal.fire({
                title: 'Event Details',
                html: '<p>Subject: ' + info.event.title + '</p>' +
                    '<p>Start: ' + info.event.start + '</p>' +
                    '<p>End: ' + info.event.end + '</p>',
                showCloseButton: true
            })
        },
        events: [
            {
                title: 'All Day Event',
                start: '2021-06-01',
            },
            {
                title: 'Long Event',
                start: '2021-06-07',
                end: '2021-06-10',
            },
            {
                groupId: 999,
                title: 'Repeating Event',
                start: '2021-06-09T16:00:00',
            },
            {
                groupId: 999,
                title: 'Repeating Event',
                start: '2021-06-16T16:00:00',
            },
            {
                title: 'Conference',
                start: '2021-06-11',
                end: '2021-06-13',
            },
            {
                title: 'Meeting',
                start: '2021-06-12T10:30:00',
                end: '2021-06-12T12:30:00',
            },
            {
                title: 'Lunch',
                start: '2021-06-12T12:00:00',
            },
            {
                title: 'Meeting',
                start: '2024-06-12T14:30:00',
            },
            {
                title: 'Happy Hour',
                start: '2021-06-12T17:30:00',
            },
            {
                title: 'Dinner',
                start: '2021-06-12T20:00:00',
            },
            {
                title: 'Birthday Party',
                start: '2021-06-13T07:00:00',
            },
            {
                title: 'Click for Google',
                url: 'http://google.com/',
                start: '2021-06-28',
            }
        ]
    });
    calendar.render();
})