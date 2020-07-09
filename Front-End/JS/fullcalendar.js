
if(window.matchMedia("(min-width: 1000px)").matches){
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {

      plugins: ['interaction','dayGrid','timeGrid', 'list', 'googleCalendar'],

      timeZone : 'UTC+2',
      locale: 'de',
      header: {
        left: 'prev,next, today',
        center: 'title',
        right: 'dayGridMonth, timeGridWeek, listYear'
      },
      buttonText:
      {
        today : 'Heute',
        dayGridMonth : 'Monat',
        timeGridWeek : 'Woche',
        listYear : 'Terminübersicht'
      },
      allDayText: 'ganztägig',
      minTime : '08:00:00',
      maxTime : '22:00:00',
      nowIndicator : true,
      showNonCurrentDates : false,
      fixedWeekCount : false,
      weekNumbers: true,
      weekNumbersWithinDays: true,
      weekNumberCalculation: 'ISO',
      displayEventTime: true, // don't show the time column in list view
      eventLimit : true,



      googleCalendarApiKey: 'AIzaSyDtPj4adqaLwWjI93G2ks3oTNVxhl459Fs',

      // Kalender ID
      events: 'johannselbst@gmail.com',

      eventClick: function(arg){
        arg.jsEvent.preventDefault()}
        ,

      //  function(arg) {
      //   // opens events in a popup window
      //   window.open(arg.event.url, 'google-calendar-event', 'width=700,height=600');
      //
      //   arg.jsEvent.preventDefault() // don't navigate in main tab
      // },

      loading: function(bool) {
        document.getElementById('loading').style.display =
          bool ? 'block' : 'none';
      }


    });

    calendar.render();


  });
}
else{
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {

      plugins: ['interaction','dayGrid','timeGrid', 'list', 'googleCalendar'],

      timeZone : 'UTC+2',
      locale: 'de',


      header: {
        left: 'prev',
        center: 'title',
        right: 'next'
      },
      buttonText:
      {
        today : 'Heute',
        dayGridMonth : 'Monat',
        timeGridWeek : 'Woche',
        listMonth : 'Terminübersicht'
      },
      titleFormat: {
        month: 'long',
      },
      allDayText: 'ganztägig',
      minTime : '08:00:00',
      maxTime : '22:00:00',
      nowIndicator : true,
      showNonCurrentDates : false,
      fixedWeekCount : true,

      weekNumberCalculation: 'ISO',
      displayEventTime: true, // don't show the time column in list view
      eventLimit : true,



      googleCalendarApiKey: 'AIzaSyDtPj4adqaLwWjI93G2ks3oTNVxhl459Fs',

      // Kalender ID
      events: 'johannselbst@gmail.com',

      // eventClick: function(arg){
      //   arg.jsEvent.preventDefault()}
      //   ,

      eventClick: function(arg) {
        // opens events in a popup window
        window.open(arg.event.url, 'google-calendar-event', 'width=700,height=600');

        arg.jsEvent.preventDefault() // don't navigate in main tab
      },

      loading: function(bool) {
        document.getElementById('loading').style.display =
          bool ? 'block' : 'none';
      }


    });

    calendar.render();


  });
}
