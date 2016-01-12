<?php
	if (isset($_POST['str'])) {
		echo "<br><br><br><hr>";
		$string = $_POST['str'];
		$cnf = $_POST['cnf'];

		echo "<h1>CNF</h1>";
		echo cetakCNF($cnf);
		echo "<h1>String</h1>";
		echo cetakSTR($string);
		echo "<h1>CYK</h1>";
		echo cetakCYK(cyk($string,$cnf));
		step($string,$cnf);
	}
	
	function cetakSTR($data)
	{
		$result = "";
		for ($i=0; $i < count($data); $i++) { 
			if($i == 0){
				$result .= $data[$i];
			} else{
				$result .= ", ".$data[$i];
			}
		}
		return $result;
	}

	function cetakCNF($data)
	{
		$result = "";
		for ($i=0; $i < count($data); $i++) {
			if ($data[$i][0]!="") {
				$result .= $data[$i][0]." &#8594; ";
				for ($j=1; $j < count($data[$i]); $j++) { 
					if ($data[$i][$j] != "") {
						if($j == 1){
							$result .= $data[$i][$j];
						}else{
							$result .= " | ".$data[$i][$j];
						}
					}
				}
				$result .= "<br>";
			}
		}
		return $result;
	}

	function cari($cari, $data)
	{
		$result = array();
		for ($i=0; $i < count($data); $i++) { 
			for ($j=1; $j < 5; $j++) { 
				if ($cari == $data[$i][$j]) {
					array_push($result, $data[$i][0]);
				}
			}
		}
		return $result;
	}

	function array_union($a=array(''), $b=array(''))
	{	
		if (count($a)!=0 && count($b)!=0) {
			$result = array();
			for ($i=0; $i < count($a); $i++) { 
				for ($j=0; $j < count($b); $j++) { 
					array_push($result, $a[$i].$b[$j]);
				}
			}
			return $result;
		} elseif (count($a)!=0 && count($b)==0) {
			return $a;
		} elseif (count($a)==0 && count($b)!=0) {
			return $b;
		} else {
			return array('&empty;');
		}
	}

	function cyk($string,$cnf)
	{
		$cyk = array();
		for ($i=1; $i <= count($string); $i++) { 
			$cyk[1][$i] = cari($string[$i-1],$cnf);
		}
		for ($j=2; $j <= count($string); $j++) { 
			for ($i=1; $i <= count($string)-$j+1; $i++) { 
				for ($k=1; $k <= $j-1; $k++) { 
					if ($k==1) {
						$cyk[$j][$i] = array_unique(cariArray(array_union($cyk[$k][$i], $cyk[$j-$k][$i+$k]),$cnf));
					}else{
						$cyk[$j][$i] = array_unique(array_merge($cyk[$j][$i],cariArray(array_union($cyk[$k][$i], $cyk[$j-$k][$i+$k]),$cnf)));
					}
				}
			}
		}
		return $cyk;
	}

	function cariArray($array,$data)
	{
		$result = array();
		for ($i=0; $i < count($array); $i++) { 
			$cari = cari($array[$i],$data);
			$result = array_merge($result,$cari);
		}
		return $result;
	}

	function cetakCYK($cyk)
	{
		$result = "
		<table>
			<tr>
				<th width='100px'></th>
				<th width='100px'>1</th>
				<th width='100px'>2</th>
				<th width='100px'>3</th>
				<th width='100px'>4</th>
				<th width='100px'>5</th>
			</tr>";
		for ($i=1; $i <= count($cyk); $i++) { 
			$result .= "
			<tr>
				<th>".($i)."</th>";
			for ($j=1; $j <= count($cyk[$i]); $j++) { 
				$sel = implode(", ", $cyk[$i][$j]);
				if ($sel == "") {
					$sel = "&empty;";
				}
				$result .= "
				<td>".$sel."</td>";
			}
			$result .= "
			</tr>";
		}
		$result .= "</table>";
		return $result;
	}

	function step($string,$cnf)
	{
		$cyk = cyk($string,$cnf);
		for ($i=1; $i <= count($string); $i++) { 
			echo "T<sub>".$i."1</sub> = ".$string[$i-1]." = ".implode(", ",cari($string[$i-1],$cnf))."<br>";
		}
		echo "<br>";
		for ($j=2; $j <= count($string); $j++) { 
			for ($i=1; $i <= count($string)-$j+1; $i++) { 
				$tot = array();
				for ($k=1; $k <= $j-1; $k++) { 
					$gab = array_union($cyk[$k][$i], $cyk[$j-$k][$i+$k]);
					$gabungan = implode(", ",$gab);
					$hsl = cariArray(array_union($cyk[$k][$i], $cyk[$j-$k][$i+$k]),$cnf);
					$tot = array_merge($tot, $hsl);
					$hasil = implode(", ",$hsl);
					if ($hasil == "") {
						$hasil = "&empty;";
					}
					echo "T<sub>".$i.$j."</sub> = T<sub>".$i.$k."</sub> - T<sub>".($i+$k).($j-$k)."</sub> = ".$gabungan." = ".$hasil;
					echo "<br>";
				}
				if ($j > 2) {
					$total = implode(", ", array_unique($tot));
					if ($total == "") {
						$total = "&empty;";
					}
					echo "<b>T<sub>".$i.$j."</sub> = ".$total."</b>";
					echo "<br>";
				}
			}
			echo "<br>";
		}
	}
?>
