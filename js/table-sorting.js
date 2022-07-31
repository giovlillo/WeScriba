$(document).ready(function(){
	
	var allrows= new Array();
	allrows = $("#large tbody").children();
	
	var rows = new Array();
	rows[0] = $(allrows).children('tr:first');
	
	var cols_length = new Array(); //to store all colums
	cols_length = $("#large thead").children(':first').children();
	
	var cols = new Array(); //to store names of columns
	
	cols[0] = $(cols_length).children('td:first');
		
	for(var i=1; i<cols_length.length;i++)
	{
		cols[i] = $(cols_length[i-1]).next();
	}
	
	for(var i=0; i<cols.length;i++)
	{
		alert($(cols[i]).html());
	}
	
	//alert($(cols_length[0]).attr("id"));
	alert("asdfadsf "+cols.length);
	
	alert(allrows.length);
	var i1=1;
	
	for(var i=1; i<allrows.length;i++)
	{
		rows[i] = $(rows[i-1]).next();
	}
	
	
		
});