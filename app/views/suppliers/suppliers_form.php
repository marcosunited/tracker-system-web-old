<h1>
    <?=$values["supplier_id"] ? "Edit" : "Add New ";?>
    Supplier
</h1>
<p><a href="<?=app('url')?>/exec/suppliers/">Back to Suppliers</a></p>

<form action='<?=app("url")?>/exec/suppliers/action/' id='supplierForm' name='supplierForm'>
    <input type='hidden' name='frm_supplier_id' id='supplier_id' value='<?=$values["supplier_id"]?>'>
    
    <label>Name</label><input name='frm_supplier_name'  id='frm_supplier_name' value='<?=$values["supplier_name"]?>'><br>
    <label>Address 1</label><input name='frm_supplier_address_1'  id='frm_supplier_address_1' value='<?=$values["supplier_address_1"]?>'><br>
    <label>Address 2</label><input name='frm_supplier_address_2'  id='frm_supplier_address_2' value='<?=$values["supplier_address_2"]?>'><br>
    <label>Suburb</label><input id="suburb_name" autocomplete="off"> <?suburbListReq('frm_suburb_id','suburbs',$values["suburb_id"],'suburb_name',"order by suburb_name asc")?><br>
    <label>Attention</label><input name='frm_supplier_attention'  id='frm_supplier_attention' value='<?=$values["supplier_attention"]?>'><br>
    <label>Phone</label><input name='frm_supplier_phone'  id='frm_supplier_phone' value='<?=$values["supplier_phone"]?>'><br>
    <label>Fax</label><input name='frm_supplier_fax'  id='frm_supplier_fax' value='<?=$values["supplier_fax"]?>'><br>
    <label>Email</label><input name='frm_supplier_email'  id='frm_supplier_email' value='<?=$values["supplier_email"]?>'><br>
    <label> </label><button id='formbutton'>Submit</button>
</form>

<script>
    $(document).ready(function(){
          $('#supplierForm').validate();
          
        //keyup event for the search box,, Update the 'Lifts DIV'
        var timer;
        $("#suburb_name").on('keyup',function()
        {
            timer && clearTimeout(timer);
            timer = setTimeout(searchSuburbs, 400);
        });

        function searchSuburbs()
        {
            typedName = $("#suburb_name").val().toLowerCase();
            
            if(typedName.length >= 3){
                $("#frm_suburb_id > option").each(function() {
                    optString = this.text.toLowerCase();
                    s = optString.search(typedName);
                    if (s>=0){
                        $("#frm_suburb_id").val(this.value);
                        return false;
                    }
                });
            }
        }
        
        
    });
</script>
