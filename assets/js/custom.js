$(document).ready(function(){
  if($(".alert").length > 0){
    $(".alert").fadeTo(2000, 500).slideUp(500, function(){
      $(".alert").slideUp(500);
    });
  }
  if($(".datatable").length > 0){
    $(".datatable").DataTable();
  }
  if($(".datepicker").length > 0){
    $(".datepicker").datepicker({
      format: 'yyyy-mm-dd'
    });
  }
  if($(".select2").length > 0){
    $(".select2").select2({
      theme: "bootstrap"
    });
  }
  $(".nama-supplier-select").change(function(){
    if($(this).val() != '') {
      $(".alamat-supplier-wrapper textarea").val(data_supplier[$(this).val()]);
      $(".alamat-supplier-wrapper").show();
    }else{
      $(".alamat-supplier-wrapper").hide();
    }
  });
  $(".nama-bahan-select").on('change', function(){
    if($(this).val() == 'other'){
      $(".nama-bahan-input").parents(".form-group").show();
      $(".nama-bahan-input").prop("disabled", false);
      $("input[name=satuan[]").val('');
      $("input[name=satuan[]").prop('readonly', false);
    }else{
      $(".nama-bahan-input").parents(".form-group").hide();
      $(".nama-bahan-input").prop("disabled", true);
      $("input[name=satuan[]").val(data_satuan_bahan[$(this).val()]);
      $("input[name=satuan[]").prop('readonly', true);
    }
  });
  $(".js-jumlah-produk").keyup(function(e){
    var harga_temp   = HapusTitik($("input[name=harga_jual]").val());
    var harga        = parseInt(harga_temp);
    var jumlah       = parseInt($(".js-jumlah-produk").val());
    var total_hrg_int= harga * jumlah;
    var total_hrg    = TambahTitik(total_hrg_int);
    if(!isNaN(total_hrg)){
      $("input[name=total_harga]").val(total_hrg);
    }
  });
  $("input[name=sesuai_alamat_pendaftaran]").change(function(){
    if($(this).is(":checked")){
      $(this).parents(".form-group").find("textarea").prop('readonly', true);
      $(this).parents(".form-group").find("textarea").prop('disabled', true);
    }else{
      $(this).parents(".form-group").find("textarea").prop('readonly', false);
      $(this).parents(".form-group").find("textarea").prop('disabled', false);
    }
  });
  $(".btn-form-clone").click(function(){
    $(".form-clone:last").clone().appendTo(".wrap-form-clone");
  });
  $("button[type=cancel]").click(function(e){
    e.preventDefault();
    window.history.back();
  });
});
function FormatCurrency(objNum){
   var num = objNum.value
   var ent, dec;
   if (num != '' && num != objNum.oldvalue){
     num = HapusTitik(num);
     if (isNaN(num)){
       objNum.value = (objNum.oldvalue)?objNum.oldvalue:'';
     } else {
       var ev = (navigator.appName.indexOf('Netscape') != -1)?Event:event;
       if (ev.keyCode == 190 || !isNaN(num.split('.')[1])){
         alert(num.split('.')[1]);
         objNum.value = TambahTitik(num.split('.')[0])+'.'+num.split('.')[1];
       }
       else{
         objNum.value = TambahTitik(num.split('.')[0]);
       }
       objNum.oldvalue = objNum.value;
     }
   }
}
function HapusTitik(num){
   return (num.replace(/\./g, ''));
}

function TambahTitik(num){
   numArr=new String(num).split('').reverse();
   for (i=3;i<numArr.length;i+=3)
   {
     numArr[i]+='.';
   }
   return numArr.reverse().join('');
}
