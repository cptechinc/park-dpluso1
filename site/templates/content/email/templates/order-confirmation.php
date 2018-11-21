<?php
$page->body = '
<!DOCTYPE html>
<html lang="en">
<head>
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
	<meta content="width=device-width" name="viewport">
	<style type="text/css">
        '.$css.'
	</style>

	<title></title>
</head>
<body>
	<table class="body">
		<tr>
			<td align="center" class="center" valign="top">
				<center data-parsed="">
					<table class="container text-center">
						<tbody>
							<tr>
								<td>
									<!-- This container adds the gap at the top of the email -->
									<table class="row grey">
										<tbody>
											<tr>
												<th class="small-12 large-12 columns first last">
													<table>
														<tr>
															<th>&#xA0;</th>
															<th class="expander"></th>
														</tr>
													</table>
												</th>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
					</table>
					<table class="container text-center">
						<tbody>
							<tr>
								<td>
									<!-- Main email content -->
									<table class="row">
										<tbody>
											<tr>
												<!-- Logo -->
												<th class="small-12 large-12 columns first last">
													<table>
														<tr>
															<th>
																<center data-parsed="">
																	<a class="text-center" href="http://www.sendwithus.com"><img alt="Logo Image" class="swu-logo" src="http://192.168.1.2/dpluso/site/assets/files/images/dplus.png"></a>
																</center>
															</th>
															<th class="expander"></th>
														</tr>
													</table>
												</th>
											</tr>
										</tbody>
									</table>
									<table class="row masthead">
										<tbody>
											<tr>
												<!-- Masthead -->
												<th class="small-12 large-12 columns first last">
													<table>
														<tr>
															<th>
																<h1 class="text-center">Your order has shipped!</h1>

															</th>
															<th class="expander"></th>
														</tr>
													</table>
												</th>
											</tr>
										</tbody>
									</table>
									<table class="row">
										<tbody>
											<tr>
												<!--This row adds the whitespace gap between masthead and digest content -->
												<th class="small-12 large-12 columns first last">
													<table>
														<tr>
															<th>&#xA0;</th>
															<th class="expander"></th>
														</tr>
													</table>
												</th>
											</tr>
										</tbody>
									</table>
									<table class="row">
										<tbody>
										    <tr>
										        <th class="small-12 large-6 columns first">
													<table>
														<tr>
															<th>
																<h4>Cptech Inc.</h4>
																<p class="small">
																    8628 Eagle Creek Circle <br>
																    Savage, MN 55378 <br>
																    Phone: 800-686-6270
																</p>
															</th>
														</tr>
													</table>
												</th>
                                                <th class="small-12 large-6 columns first">
													<table>
														<tr> <td>Order #</td> <td>455948</td> </tr>
														<tr> <td>Order Date</td> <td>04/11/17</td> </tr>
														<tr> <td>Ship Date</td> <td>04/15/17</td> </tr>
													</table>
												</th>
										    </tr>
										</tbody>
									</table>
									<table class="row">
										<tbody>
											<tr>
												<!-- spacer  -->
												<th class="small-12 large-12 columns first last">
													<table>
														<tr>
															<th>
																<hr>
																&#xA0;
															</th>
															<th class="expander"></th>
														</tr>
													</table>
												</th>
											</tr>
										</tbody>
									</table>
									<table class="row">
										<tbody>
											<tr>
												<!-- Digest Content 2 columns-->
												<th class="small-12 large-6 columns first">
													<table>
														<tr>
															<th>
																<h5>Billing Address</h5>
																<p>John Doe <br>
																123 Real St. <br>
																Anywhere, MN 55337 </p>
															</th>
														</tr>
													</table>
												</th>
												<th class=" small-12 large-6 columns first">
													<table>
														<tr>
															<th>
																<h5>Shipping Address</h5>
																<p>John Doe <br>
																123 Real St. <br>
																Anywhere, MN 55337 </p>
															</th>
														</tr>
													</table>
												</th>
											</tr>
										</tbody>
									</table>
									<hr>
									<table class="row show-for-large">
										<tbody>
											<tr>
												<!-- Receipt Header. Hidden for mobile-->
												<th class="small-12 large-4 columns first">
													<table>
														<tr>
															<th><b>Item</b></th>
														</tr>
													</table>
												</th>
												<th class="small-12 large-2 columns">
													<table>
														<tr>
															<th><b>Price</b></th>
														</tr>
													</table>
												</th>
												<th class="small-12 large-2 columns">
													<table>
														<tr>
															<th><b>Quantity</b></th>
														</tr>
													</table>
												</th>
												<th class="small-12 large-2 columns">
													<table>
														<tr>
															<th><b>Tax</b></th>
														</tr>
													</table>
												</th>
												<th class="small-12 large-2 columns last">
													<table>
														<tr>
															<th><b>Total</b></th>
														</tr>
													</table>
												</th>
											</tr>
										</tbody>
									</table>
									<table class="row">
										<tbody>
											<tr>
												<td></td>
											</tr>
										</tbody>
										<tbody>
											<tr>
												<!-- Receipt first row -->
												<th class="small-4 large-4 columns first">
													<table>
														<tr>
															<th>Widget 1</th>
														</tr>
													</table>
												</th>
												<th class="small-2 large-2 columns">
													<table>
														<tr>
															<th>$2.99</th>
														</tr>
													</table>
												</th>
												<th class="small-2 large-2 columns">
													<table>
														<tr>
															<th>1</th>
														</tr>
													</table>
												</th>
												<th class="small-2 large-2 columns">
													<table>
														<tr>
															<th>$0.00</th>
														</tr>
													</table>
												</th>
												<th class="small-2 large-2 columns last">
													<table>
														<tr>
															<th>$2.99</th>
														</tr>
													</table>
												</th>
											</tr>
										</tbody>
									</table>
									<table class="row">
										<tbody>
											<tr>
												<!-- Receipt 2nd row -->
												<th class="small-4 large-4 columns first">
													<table>
														<tr>
															<th>Widget 2</th>
														</tr>
													</table>
												</th>
												<th class="small-2 large-2 columns">
													<table>
														<tr>
															<th>$5.99</th>
														</tr>
													</table>
												</th>
												<th class="small-2 large-2 columns">
													<table>
														<tr>
															<th>1</th>
														</tr>
													</table>
												</th>
												<th class="small-2 large-2 columns">
													<table>
														<tr>
															<th>$0.00</th>
														</tr>
													</table>
												</th>
												<th class="small-2 large-2 columns last">
													<table>
														<tr>
															<th>$5.99</th>
														</tr>
													</table>
												</th>
											</tr>
										</tbody>
									</table>
                                    <hr>
									<table class="row">
										<tbody>
											<tr>
												<!-- Receipt total -->
												<th class="small-4 large-4 columns first">
													<table>
														<tr>
															<th>&#xA0;</th>
														</tr>
													</table>
												</th>
												<th class="small-2 large-2 columns">
													<table>
														<tr>
															<th>&#xA0;</th>
														</tr>
													</table>
												</th>
												<th class="small-2 large-2 columns">
													<table>
														<tr>
															<th>&#xA0;</th>
														</tr>
													</table>
												</th>
												<th class="small-2 large-2 columns">
													<table>
														<tr>
															<th>Total</th>
														</tr>
													</table>
												</th>
												<th class="small-2 large-2 columns last">
													<table>
														<tr>
															<th><b>$8.98</b></th>
														</tr>
													</table>
												</th>
											</tr>
										</tbody>
									</table>
									<hr>
									<table class="row">
										<tbody>
											<tr>
												<!-- secondary email content -->
												<th class="small-12 large-12 columns first last">
													<table>
														<tr>
															<th>
																<p>Freight and taxes will be calculated at the time of shipping and will be added to the invoice.  For credit card orders your credit card will be charged at the time of shipping once freight and taxes have been added. Once the order ships you should receive an email</p>
															</th>
															<th class="expander"></th>
														</tr>
													</table>
												</th>
											</tr>
										</tbody>
									</table>
									<table class="row">
										<tbody>
											<tr>
												<!-- This container adds the gap between digest content and CTA  -->
												<th class="small-12 large-12 columns first last">
													<table>
														<tr>
															<th>&#xA0;</th>
															<th class="expander"></th>
														</tr>
													</table>
												</th>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
					</table><!-- / End Email Content -->
					<table class="container text-center">
						<tbody>
							<tr>
								<td>
									<!-- Footer -->
									<table class="row grey">
										<tbody>
											<tr>
												<th class="small-12 large-12 columns first last">
													<table>
														<tr>
															<th>
																<p class="text-center footercopy">&#xA9; Copyright 2016 CPTech Inc. All Rights Reserved.</p>
															</th>
															<th class="expander"></th>
														</tr>
													</table>
												</th>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
					</table>
				</center>
			</td>
		</tr>
	</table>
</body>
</html>
';
