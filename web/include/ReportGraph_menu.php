				<?php if($user_type == 'admin' || 'superadmin') {?>
					<a class="list-group-item <?php echo $ReportRevenueGraph; ?>" href="ReportRevenueGraph"><i class="iconfa-money"></i> &nbsp; Revenue Graph</a>
					<a class="list-group-item <?php echo $ReportCollectionSumGraph; ?>" href="ReportCollectionSumGraph"><i class="iconfa-money"></i> &nbsp; Collection Summary Graph</a>
					<a class="list-group-item <?php echo $ReportDueGraph; ?>" href="ReportDueGraph"><i class="iconfa-money"></i> &nbsp; Due Bill Graph</a>
					<a class="list-group-item <?php echo $ReportZoneClientsGraph; ?>" href="ReportZoneClientsGraph"><i class="iconfa-money"></i> &nbsp; Zone Clients Graph</a>
					<a class="list-group-item <?php echo $ReportCollectionGraph; ?>" href="ReportCollectionGraph"><i class="iconfa-money"></i> &nbsp; Collection & Discount Graph</a>
<!--					<a class="list-group-item <?php echo $ReportClients; ?>" href="ReportClients"><i class="iconfa-user"></i> &nbsp; Clients </a>
					<a class="list-group-item <?php echo $ReportClientsNew; ?>" href="ReportClientsNew"><i class="iconfa-user"></i> &nbsp; New Clients </a>
					<a class="list-group-item <?php echo $ReportSignupBill; ?>" href="ReportSignupBill"><i class="iconfa-money"></i> &nbsp; Signup Bill </a>
					<a class="list-group-item <?php echo $ReportCollection; ?>" href="ReportCollection"><i class="iconfa-money"></i> &nbsp; Collection </a>
					<a class="list-group-item <?php echo $ReportClientLaser; ?>" href="ReportClientLaser"><i class="iconfa-money"></i> &nbsp; Client Laser </a>
					<a class="list-group-item <?php echo $ReportBillPrint; ?>" href="ReportBillPrint"><i class="iconfa-print"></i> &nbsp; Bill Print </a>-->
				<?php } if($user_type == 'billing') {?>
					<a class="list-group-item <?php echo $ReportRevenueGraph; ?>" href="ReportRevenueGraph"><i class="iconfa-money"></i> &nbsp; Revenue Graph</a>
					<a class="list-group-item <?php echo $ReportCollectionSumGraph; ?>" href="ReportCollectionSumGraph"><i class="iconfa-money"></i> &nbsp; Collection Summary Graph</a>
					<a class="list-group-item <?php echo $ReportDueGraph; ?>" href="ReportDueGraph"><i class="iconfa-money"></i> &nbsp; Due Bill Graph</a>
					<a class="list-group-item <?php echo $ReportZoneClientsGraph; ?>" href="ReportZoneClientsGraph"><i class="iconfa-money"></i> &nbsp; Zone Clients Graph</a>
				<?php } if($user_type == 'accounts') {?>
					<a class="list-group-item <?php echo $ReportRevenueGraph; ?>" href="ReportRevenueGraph"><i class="iconfa-money"></i> &nbsp; Revenue Graph</a>
					<a class="list-group-item <?php echo $ReportCollectionSumGraph; ?>" href="ReportCollectionSumGraph"><i class="iconfa-money"></i> &nbsp; Collection Summary Graph</a>
					<a class="list-group-item <?php echo $ReportDueGraph; ?>" href="ReportDueGraph"><i class="iconfa-money"></i> &nbsp; Due Bill Graph</a>
					<a class="list-group-item <?php echo $ReportZoneClientsGraph; ?>" href="ReportZoneClientsGraph"><i class="iconfa-money"></i> &nbsp; Zone Clients Graph</a>
				<?php } if($user_type == 'support') {?>
					<a class="list-group-item <?php echo $ReportRevenueGraph; ?>" href="ReportRevenueGraph"><i class="iconfa-money"></i> &nbsp; Revenue Graph</a>
					<a class="list-group-item <?php echo $ReportCollectionSumGraph; ?>" href="ReportCollectionSumGraph"><i class="iconfa-money"></i> &nbsp; Collection Summary Graph</a>
					<a class="list-group-item <?php echo $ReportDueGraph; ?>" href="ReportDueGraph"><i class="iconfa-money"></i> &nbsp; Due Bill Graph</a>
					<a class="list-group-item <?php echo $ReportZoneClientsGraph; ?>" href="ReportZoneClientsGraph"><i class="iconfa-money"></i> &nbsp; Zone Clients Graph</a>
				<?php } if($user_type == 'client') {?>
					<a class="list-group-item <?php echo $ReportBookStock; ?>" href="ReportBookStock"><i class="iconfa-book"></i> &nbsp; Book Stock Report </a>
				<?php } if($user_type == 'office') {?>
					<a class="list-group-item <?php echo $ReportRevenueGraph; ?>" href="ReportRevenueGraph"><i class="iconfa-money"></i> &nbsp; Revenue Graph</a>
					<a class="list-group-item <?php echo $ReportCollectionSumGraph; ?>" href="ReportCollectionSumGraph"><i class="iconfa-money"></i> &nbsp; Collection Summary Graph</a>
					<a class="list-group-item <?php echo $ReportDueGraph; ?>" href="ReportDueGraph"><i class="iconfa-money"></i> &nbsp; Due Bill Graph</a>
					<a class="list-group-item <?php echo $ReportZoneClientsGraph; ?>" href="ReportZoneClientsGraph"><i class="iconfa-money"></i> &nbsp; Zone Clients Graph</a>
					<a class="list-group-item <?php echo $ReportStockEqupment; ?>" href="ReportStockEqupment"><i class="iconfa-gift"></i> &nbsp; Equipment Stock Report </a>		
				<?php } ?>