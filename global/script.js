function actAdd(){
	 document.formHidden.act.value='add';
	 document.formHidden.submit();
}
function actEdit(id){
	 document.formHidden.act.value='edit';
	 document.formHidden.id.value=id;
	 document.formHidden.submit();
}
function actDetil(id){
	 document.formHidden.act.value='detil';
	 document.formHidden.id.value=id;
	 document.formHidden.submit();
}
function actAktif(id){
	 document.formHidden.act.value='aktif';
	 document.formHidden.id.value=id;
	 document.formHidden.submit();
}
function actDel(id){
	if(confirm('Apakah Anda ingin Menghapus Data ini?')){
		 document.formHidden.act.value='del';
		 document.formHidden.id.value=id;
		 document.formHidden.submit();
	}	
}
function actBatal(){
	 document.formHidden.act.value='';
	 document.formHidden.submit();
}
