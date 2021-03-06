	<?php require("header.php"); ?>
	<title>Thêm kết quả - Giảng viên</title>
	<link rel="stylesheet" href="css/style.css">
	
</head>




<body>
    <?php require("topnavbar.php") ?>
    <?php
		if( !(isset($_SESSION["userid"]) && $_SESSION["userloaiuser"] == 2) )
			header("Location:index.php");
	?>
  	<hr><hr><hr>
  	
  	<?php
		if(isset($_POST["THEM"])&&($_POST["THEM"]=="Thêm"))
		{
			$soluong = $_SESSION["slkq2"];
			$str_themketqua = "insert into kqkhoa(MaKhoa, MaSV, MaLop, DiemTongKet, KetQua) values";
			for($i=1; $i<=$soluong; $i++)
			{
				$makhoa = $_POST["makhoa"];
				$masv = $_POST["masv".$i];
				$malop = $_POST["malop".$i];
				$diemtk = $_POST["diemtk".$i];
				if($diemtk>=5)
					$ketqua="Đạt";
				else
					$ketqua="Chưa đạt";
				if($diemtk!="")
					$str_themketqua.="('$makhoa', '$masv', '$malop', '$diemtk', '$ketqua'), ";
				
			}
			$str_themketqua = rtrim($str_themketqua, ", ");
			$str_themketqua.=" ON DUPLICATE KEY UPDATE DiemTongKet = values(DiemTongKet), KetQua = values (KetQua)";

			mysqli_query($conn, $str_themketqua);
			
		}
	?>
	
  	
   	<div class="container">
  		<div class="row">
				<div class="col-lg-2">&nbsp;</div>
				<div class="col-lg-8">
					<div class="alert alert-warning alert-dismissable">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<strong>Lưu ý:</strong><br>_ Giảng viên chỉ có thể <strong>thêm</strong> một chứ không thể<strong> CẬP NHẬT </strong>kết quả, một khi đã thêm thì không thể sửa, nếu muốn sửa phải liên hệ nhờ admin sửa.<br>_ Giảng viên chỉ có thể thêm kết quả cho các khóa mà mình dạy.
					</div>
					</div>
				<div class="col-lg-2">&nbsp;</div>
		</div>
  		<hr><hr><hr>
   		<div class="row">
   			<div class="col-lg-12">
				<form class="" action="giangvien-themkq.php" method="post">
				
				<label><h3>Chọn mã khóa</h3></label> &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
				<?php
					$str_laykhoa = "select * from khoa where MaGV='$_SESSION[userid]'";
					$kq_laykhoa = mysqli_query($conn, $str_laykhoa);
					echo "<select name='makhoa' class='input-lg' id='chonmk'>";
					while($row1 = mysqli_fetch_array($kq_laykhoa))
					{
						echo "<option value='$row1[MaKhoa]'>$row1[MaKhoa]</option>";
					}
					echo "</select>";
				?>
				
				<table class="table table-hover">
					<thead>
						<th><label>Mã lớp</label></th>
						<th><label>Mã sinh viên</label></th>
						<th><label>Họ tên sinh viên</label></th>
						<th><label>Điểm tổng kết</label></th>
					</thead>

					<tbody id='landing'>

					</tbody>
				</table>
				<input class="btn btn-success center-block btn-lg" value="Thêm" name="THEM" type="submit">
				</form>
			</div>
		</div>
	</div>
	
    <script>
		$(document).ready(function(){
			var makhoa = $("#chonmk").val();
			$.post("giangvien-themkq-ajax.php", { makhoa:makhoa }, function(data, status){
			if(status=="success")
			{
				$("#landing").html(data);	
			}
			});			
			
			$("#chonmk").change(function(){
				var makhoa = this.value;
				$.post("giangvien-themkq-ajax.php", { makhoa:makhoa }, function(data, status){
				if(status=="success")
				{
					$("#landing").html(data);	
				}
				});
			});
		});
	</script>  

<?php require("footer.php") ?>