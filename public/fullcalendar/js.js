window.onload = () => {
    let calendarEl = document.getElementById('calendar');
    let calendar = new FullCalendar.Calendar(calendarEl, {
        plugins: ['dayGrid', 'timeGrid', 'list', 'interaction'],
        defaultView: 'timeGridWeek',
        locale: 'fr',
        buttonText: {
            today: 'Aujourd\'hui',
            month: 'Mois',
            week: 'Semaine',
            day: 'Jour',
            list: 'Liste'
        },
        header: {
            left: 'title',
            center: '',
            right: 'dayGridMonth,dayGridWeek,dayGridDay,listMonth prev,next today'
        },
        firstDay: 1,
        scrollTime: "07:30:00",
        hiddenDays: [0, 6],
        nowIndicator: true,
        minTime: "07:30:00",
        maxTime: "17:30:00",
        handleWindowResize: true,
        events: appointments,
        eventRender: function (info) {
            $(info.el).tooltip({title: info.event.extendedProps.description});
        }
    });
    calendar.render();
};