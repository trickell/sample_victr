$(function(){

  // Handle click o repository row
  $("#repositoryTable tbody tr").click(function(){
    var html = $(this).find('.details').html();

    uglipop({
        class:'modalBox', 
        source:'html',
        content: html
      });
  });

});
