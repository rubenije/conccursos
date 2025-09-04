var frm = $('#ingreso');

frm.submit(function (e) {
    e.preventDefault();
    if(validaForm()){
      $(':button[type="submit"]').prop('disabled', true);
      $.ajax({
          type: frm.attr('method'),
          url: frm.attr('action'),
          data: frm.serialize(),
          success: function (data) {
              window.location = data.modal+'.php';
              return true;
              
          },
          error: function (data) {
              return false;
              window.location = 'ups.php';
              return false;
          },
      });
    }
});


function validaForm(){
 
  var master_id     =  $("#master_id").val();
  

  if(master_id == ''){
    showError('master_id', 'Ingresa tu ID de usuario')
    return false;
  }
  
  return true;
}

function showError(name, msg){
  $("#"+name+"_help").html(msg);
  $("#"+name+"_help").fadeIn('fast');
  $("#"+name).focus();
  setTimeout(function () {
    $("#"+name+"_help").fadeOut(1000);
  }, 4000)
}

function closeModal(id){
    const container = document.getElementById(id);
    myModal = bootstrap.Modal.getOrCreateInstance(container);
    myModal.hide();
}

$(".close").on('click', function(){
    const myModal = $( this ).data( "modal");
    console.log('myModal', myModal);
    closeModal(myModal);
})