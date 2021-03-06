    <div class="main" id="onloadMainEcosystemsPage" style="display:none;">
      
			<?php
			
				$inpage = $SqlChecker->imtsqlclean(@$_GET["inpage"]);
				$inpage = $SqlChecker->CheckGET(htmlspecialchars($inpage));
				
				if(empty($inpage))
					header("location:home.html");
				else
				{
					if (ob_get_level() == 0)
						ob_start();
				
					$query = $DBFunctions->selectAll("SELECT p.information as inf,p.seourl as seourl,c.name as cat FROM posts as p,category as c WHERE c.seourl = '$inpage' and p.categoryid = c.id and p.status = 1");
					
					if($isPublisher)
						echo '<br/ ><a href="createpost/'.$inpage.'.html" class="transparentButton followePannelButton" type="button" name="createpost">Yeni Post Oluştur</a><br/ ><br/ >';
					
					if (count($query) == 0) {
						echo '<tr><td>Henüz Paylaşım Yok ! </td></tr>';
					} else {
						
						for($i=0; $i<count($query); $i++)
						{
							flush();
							ob_flush();
							
							$data = $DBFunctions->PDO_fetch_array($query, $i);
							$information = json_decode($data['inf'],true);
							if($information)
							{
								$title = $information['title'];
								$description = $information['description'];
								$image = $information['image'];
								$date = $information['date'];
								$category = $data['cat'];
								$ecosystem = $data['eco'];
								$region = $data['reg'];
								
								$seourl = $data['seourl'];
								
								echo '
									<div class="PicMain">
										<div class="imgM">
											  <img src="assets/img/posts/'.$image.'" alt="">
										</div>
										</br>
										<div class="PicBottom">
											<h6>'.$cat.'</h6>
											<b>'.$title.'  |  '.$date.'</b>
											<div class="">
												<p>'.((strlen($description) > 260) ? substr($description,0,260).'... <a href="/dashboard/posts/'.$seourl.'.html">Devamı</a>' : $description).'</p>
											</div>

										</div>

									</div>
									';
							}
						}
					}
				  
					ob_end_flush();
			  
				}
			  ?>
    </div>
