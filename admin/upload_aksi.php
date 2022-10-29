<?php 
include 'koneksi.php';
include "import/excel_reader2.php";

 if ($_POST['submit'] == "submit") {
		$type = explode(".",$_FILES['minat']['name']);
		
		if (empty($_FILES['minat']['name'])) {
			?>
				<script language="JavaScript">
					alert('Oops! Please fill all / select file ...');
					// document.location='./';
				</script>
			<?php
		}
		else if(strtolower(end($type)) !='xls'){
			?>
				<script language="JavaScript">
					alert('Oops! Please upload only Excel XLS file ...');
					// document.location='./';
				</script>
			<?php
		}
		
		else{
		$target = basename($_FILES['minat']['name']) ;
		move_uploaded_file($_FILES['minat']['tmp_name'], $target);
	
		$data    =new Spreadsheet_Excel_Reader($_FILES['minat']['name'],false);
	
		$baris = $data->rowcount($sheet_index=0);
	
		for ($i=2; $i<=$baris; $i++){
			$nib = $data->val($i, 1);
			$nama = $data->val($i, 2);
			$penanaman_modal = $data->val($i, 3);
			$jenis_perusahaan = $data->val($i, 4);
			$jenis = $data->val($i, 5);
			$kecamatan = $data->val($i, 6);
			
			$query = $mysqli->query("INSERT INTO minat_investasi (nib, nama, penanaman_modal, jenis_perusahaan, id_jenis, id_kecamatan) 
			VALUES ('$nib', '$nama', '$penanaman_modal', '$jenis_perusahaan', '$jenis', '$kecamatan')");        
		}
	
			if(!$query){
				?>
					<script language="JavaScript">
						alert('<b>Oops!</b> 404 Error Server.');
						// document.location='./';
					</script>
				<?php
			}
			else{
				?>
					<script language="JavaScript">
						alert('Import data excel berhasil');
						document.location='minat_investasilist.php';
					</script>
				<?php
			}
		unlink($_FILES['minat']['name']);
		}
	}
?>

