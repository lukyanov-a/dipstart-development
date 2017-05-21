var intervalTimer = null;
var titleStar = '***************';
var titleMessage = 'Новое событие';
var defaultTitle = document.title;
var refreshUrl;

$(document).ready(function(){
	setInterval(update_events, 5000);
	$(window).focus(removeTitleSignal);
	$(window).mousemove(removeTitleSignal);
	if (window.location.pathname == '/project/event/salesManagerIndex') {
		refreshUrl = '/project/event/refreshForSalesManager';
	} else {
		refreshUrl = '/project/event/refresh';
	}
});

function removeTitleSignal(){
	clearInterval(intervalTimer);
	intervalTimer = null;
	document.title = defaultTitle;
}

function getEventObjects(html){
	var events = [];
	$(html).find('tr').each(function(){
		if ($(this).data('id'))
			events.push({
				id: $(this).data('id'),
				type: $(this).data('type')
			});
	});
	return events;
}

function checkNewEvent(data){
	var oldEvents = getEventObjects($('.events-list').html());
	var newEvents = getEventObjects(data);
	var newEvent = null;
	newEvents.forEach(function(newItem){
		var isNew = oldEvents.every(function(oldItem){
			return oldItem.id != newItem.id;
		});
		if (isNew)
			newEvent = newItem;
	});
	return newEvent;
}

function titleSignal(){
	document.title = document.title == titleStar ? titleMessage : titleStar;
}

function update_events(){
    $.post(refreshUrl, {}, function(data){
		var newEvent = checkNewEvent(data);
		$('.events-list').html(data);
		if (newEvent)
		{
			if (newEvent.type == 1)
			{
				titleMessage = 'Новый заказ';
				$('#is-new-order')[0].play();
			}
			else
			{
				titleMessage = 'Новое событие';
				$('#is-new-event')[0].play();
			}
			if (!intervalTimer)
				intervalTimer = setInterval(titleSignal, 500);
		}
	});
};