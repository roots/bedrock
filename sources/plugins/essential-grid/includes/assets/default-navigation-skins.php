<?php
$default = array(
  array('name' => 'Flat Light','handle' => 'flat-light','css' => '/********************************
	-	FLAT LIGHT BUTTONS -
*********************************/
.flat-light .navigationbuttons,
.flat-light .esg-pagination,
.flat-light .esg-filters{	text-transform:uppercase;
							text-align: center;
						}

.flat-light .esg-filterbutton,
.flat-light .esg-navigationbutton,
.flat-light .esg-sortbutton,
.flat-light .esg-cartbutton {	color:#000;
								margin-right:5px;
								cursor:pointer;
								position: relative;
								z-index:2;
								padding:1px 30px;
								border:none;
								line-height:38px;
								border-radius:5px;
								-moz-border-radius:5px;
								-webkit-border-radius:5px;
								font-size:12px;
								font-weight:700;
								font-family:"Open Sans",sans-serif;
								display: inline-block;
								background: #fff;
								margin-bottom:5px;
							}

.flat-light .esg-navigationbutton	{ padding:2px 12px; }
.flat-light .esg-navigationbutton *	{ color:#000; }
.flat-light .esg-pagination-button:last-child { margin-right: 0; }

.flat-light  .esg-sortbutton-wrapper,
.flat-light  .esg-cartbutton-wrapper { display:inline-block; }
.flat-light  .esg-sortbutton-order,
.flat-light  .esg-cartbutton-order {	display:inline-block;
										vertical-align:top;
										border:none;
										width:40px;
										line-height:40px;
										border-radius:5px;
										-moz-border-radius:5px;
										-webkit-border-radius:5px;
										font-size:12px;
										font-weight:700;
										color:#999;
										cursor: pointer;
										background:#eee;
										background: #fff;
										margin-left:5px;
									}

.flat-light .esg-cartbutton {	color:#fff;
								cursor: default !important;
							}
.flat-light .esg-cartbutton .esgicon-basket	{
												color:#fff;
												font-size:15px;
												line-height:15px;
												margin-right:10px;
											}
.flat-light .esg-cartbutton-wrapper { cursor: default !important; }

.flat-light .esg-sortbutton,
.flat-light .esg-cartbutton {	display:inline-block;
								position:relative;
								cursor: pointer;
								margin-right:0px;
								border-radius:5px;
								-moz-border-radius:5px;
								-webkit-border-radius:5px;
							}

.flat-light .esg-navigationbutton:hover,
.flat-light .esg-filterbutton:hover,
.flat-light .esg-sortbutton:hover,
.flat-light .esg-sortbutton-order:hover,
.flat-light .esg-cartbutton-order:hover,
.flat-light .esg-filterbutton.selected {
										border-color:none;color:#000;
										background:#fff;
									   }

.flat-light .esg-navigationbutton:hover * { color:#333; }

.flat-light .esg-sortbutton-order.tp-desc:hover	{ color:#333; }

.flat-light .esg-filter-checked	{	padding:1px 3px;
									color:#cbcbcb;
									background:#cbcbcb;
									margin-left:7px;
									font-size:9px;
									font-weight:300;
									line-height:9px;
									vertical-align: middle;
								}
.flat-light .esg-filterbutton.selected .esg-filter-checked,
.flat-light .esg-filterbutton:hover .esg-filter-checked	{
															padding:1px 3px 1px 3px;
															color:#fff;
															background:#000;
															margin-left:7px;
															font-size:9px;
															font-weight:300;
															line-height:9px;
															vertical-align: middle;
														}'),
  array('name' => 'Flat Dark','handle' => 'flat-dark','css' => '/********************************
	-	FLAT DARK BUTTONS -
*********************************/
.flat-dark .navigationbuttons,
.flat-dark .esg-pagination,
.flat-dark .esg-filters {
							text-transform:uppercase;
							text-align: center;
						}

.flat-dark .esg-filterbutton,
.flat-dark .esg-navigationbutton,
.flat-dark .esg-sortbutton,
.flat-dark .esg-cartbutton {color:#fff;
							margin-right:5px;
							cursor:pointer;
							padding:1px 30px;
							border:none;
							line-height:38px;
							border-radius:5px;
							-moz-border-radius:5px;
							-webkit-border-radius:5px;
							font-size:12px;
							font-weight:600;
							font-family:"Open Sans",sans-serif;
							display: inline-block;
							background:#3a3a3a;
							background: rgba(0,0,0,0.2);
							margin-bottom:5px;
							}

.flat-dark .esg-navigationbutton { padding:1px 18px; }
.flat-dark .esg-navigationbutton * { color:#fff; }
.flat-dark .esg-pagination-button:last-child,
.flat-dark .esg-filterbutton:last-child{ margin-right: 0; }
.flat-dark .esg-left, .flat-dark .esg-right { padding:1px 12px; }

.flat-dark  .esg-sortbutton-wrapper,
.flat-dark  .esg-cartbutton-wrapper	{ display:inline-block; }
.flat-dark  .esg-sortbutton-order,
.flat-dark  .esg-cartbutton-order { display:inline-block;
									vertical-align:top;
									border:none;
									width:40px;
									line-height:40px;
									border-radius:5px;
									-moz-border-radius:5px;
									-webkit-border-radius:5px;
									font-size:12px;
									font-weight:700;
									color:#999;
									cursor: pointer;
									background:#eee;
									background: rgba(0,0,0,0.2);
									margin-left:5px;
								}

.flat-dark .esg-cartbutton {color:#fff;
							cursor: default !important;
							}
.flat-dark .esg-cartbutton .esgicon-basket {color:#fff;
											font-size:15px;
											line-height:15px;
											margin-right:10px;
											}
.flat-dark  .esg-cartbutton-wrapper	{ cursor: default !important; }

.flat-dark .esg-sortbutton,
.flat-dark .esg-cartbutton { display:inline-block;
							position:relative;
							cursor: pointer;
							margin-right:0px;
							border-radius:5px;
							-moz-border-radius:5px;
							-webkit-border-radius:5px;
							}

.flat-dark .esg-navigationbutton:hover,
.flat-dark .esg-filterbutton:hover,
.flat-dark .esg-sortbutton:hover,
.flat-dark .esg-sortbutton-order:hover,
.flat-dark .esg-cartbutton-order:hover,
.flat-dark .esg-filterbutton.selected { color:#fff;
										border-color:none;
										background:#4a4a4a;
										background: rgba(0,0,0,0.5);
									 }

.flat-dark .esg-navigationbutton:hover * { color:#fff; }
.flat-dark .esg-sortbutton-order.tp-desc:hover	{ color:#fff; }
.flat-dark .esg-filter-checked {padding:1px 3px;
								color:transparent;
								background:#000;
								background: rgba(0,0,0,0.2);
								margin-left:7px;
								font-size:9px;
								font-weight:300;
								line-height:9px;
								vertical-align: middle:
								}
								
.flat-dark .esg-filterbutton.selected .esg-filter-checked,
.flat-dark .esg-filterbutton:hover .esg-filter-checked {padding:1px 3px 1px 3px;
														color:#fff;
														background:#000;
														background: rgba(0,0,0,0.2);
														margin-left:7px;
														font-size:9px;
														font-weight:300;
														line-height:9px;
														vertical-align: middle
														}'),
  array('name' => 'Minimal Dark','handle' => 'minimal-dark','css' => '/********************************
	-	MINIMAL DARK BUTTONS -
*********************************/

.minimal-dark .navigationbuttons,
.minimal-dark .esg-pagination,
.minimal-dark .esg-filters { text-align: center; }

.minimal-dark .esg-filterbutton,
.minimal-dark .esg-navigationbutton,
.minimal-dark .esg-sortbutton,
.minimal-dark .esg-cartbutton { color:#fff;
								color:rgba(255,255,255,1);
								margin-right:5px;
								cursor:pointer;
								padding:0px 17px;
								border:1px solid rgb(255,255,255);
								border:1px solid rgba(255,255,255,0.1);
								line-height:38px;
								border-radius:5px;
								-moz-border-radius:5px;
								-webkit-border-radius:5px;
								font-size:12px;
								font-weight:600;
								font-family:"Open Sans",sans-serif;
								display: inline-block;
								background:transparent;
								margin-bottom:5px;
								}


.minimal-dark .esg-navigationbutton * {
										color:#fff;
										color:rgba(255,255,255,1);
									}
.minimal-dark .esg-navigationbutton	{ padding:0px 11px; }
.minimal-dark .esg-pagination-button { padding:0px 16px; }
.minimal-dark .esg-pagination-button:last-child { margin-right: 0; }

.minimal-dark  .esg-sortbutton-wrapper,
.minimal-dark  .esg-cartbutton-wrapper { display:inline-block; }
.minimal-dark  .esg-sortbutton-order,
.minimal-dark  .esg-cartbutton-order {  display:inline-block;
										vertical-align:top;
										border:1px solid rgb(255,255,255);
										border:1px solid rgba(255,255,255,0.1);
										width:40px;
										line-height:38px;
										border-radius: 0px 5px 5px 0px;
										-moz-border-radius: 0px 5px 5px 0px;
										-webkit-border-radius: 0px 5px 5px 0px;
										font-size:12px;
										font-weight:600;
										color:#fff;
										cursor: pointer;
										background:transparent;
									}

.minimal-dark .esg-cartbutton {
								color:#fff;
								cursor: default !important;
							  }
.minimal-dark .esg-cartbutton .esgicon-basket {
												color:#fff;
												font-size:15px;
												line-height:15px;
												margin-right:10px;
											  }
.minimal-dark  .esg-cartbutton-wrapper { cursor: default !important; }

.minimal-dark .esg-sortbutton,
.minimal-dark .esg-cartbutton {
								display:inline-block;
								position:relative;
								cursor: pointer;
								margin-right:0px;
								border-right:none;
								border-radius:5px 0px 0px 5px;
								-moz-border-radius:5px 0px 0px 5px;
								-webkit-border-radius:5px 0px 0px 5px;
							   }

.minimal-dark .esg-navigationbutton:hover,
.minimal-dark .esg-filterbutton:hover,
.minimal-dark .esg-sortbutton:hover,
.minimal-dark .esg-sortbutton-order:hover,
.minimal-dark .esg-cartbutton-order:hover,
.minimal-dark .esg-filterbutton.selected {
											border-color:#fff;
											border-color:rgba(255,255,255,0.2);
											color:#fff;
											box-shadow: 0px 3px 5px 0px rgba(0,0,0,0.13);
											background:#333;
											background: rgba(255,255,255,0.1);
										  }

.minimal-dark .esg-navigationbutton:hover * { color:#fff; }

.minimal-dark .esg-sortbutton-order.tp-desc:hover {	border-color:#fff;
													border-color:rgba(255,255,255,0.2);
													color:#fff;
													box-shadow: 0px -3px 5px 0px rgba(0,0,0,0.13) !important;
												  }

.minimal-dark .esg-filter-checked {
									padding:1px 3px;
									color:transparent;
									background:#000;
									background: rgba(0,0,0,0.10);
									margin-left:7px;
									font-size:9px;
									font-weight:300;
									line-height:9px;
									vertical-align: middle;
								  }
.minimal-dark .esg-filterbutton.selected .esg-filter-checked,
.minimal-dark .esg-filterbutton:hover .esg-filter-checked {
															padding:1px 3px 1px 3px;
															color:#fff;
															background:#000;
															background: rgba(0,0,0,0.10);
															margin-left:7px;
															font-size:9px;
															font-weight:300;
															line-height:9px;
															vertical-align: middle;
														  }'),
  array('name' => 'Minimal Light','handle' => 'minimal-light','css' => '/******************************
	-	MINIMAL LIGHT SKIN	-
********************************/

.minimal-light .navigationbuttons,
.minimal-light .esg-pagination,
.minimal-light .esg-filters { text-align: center; }

.minimal-light .esg-filterbutton,
.minimal-light .esg-navigationbutton,
.minimal-light .esg-sortbutton,
.minimal-light .esg-cartbutton a{ 
								color:#999;
								margin-right:5px;
								cursor:pointer;
								padding:0px 16px;
								border:1px solid #e5e5e5;
								line-height:38px;
								border-radius:5px;
								-moz-border-radius:5px;
								-webkit-border-radius:5px;
								font-size:12px;
								font-weight:700;
								font-family:"Open Sans",sans-serif;
								display: inline-block;
								background:#fff;
								margin-bottom:5px;
							  }

/*.minimal-light .esg-cartbutton a { color: #999; }*/

.minimal-light .esg-navigationbutton * { color:#999; }
.minimal-light .esg-navigationbutton	{ padding:0px 16px; }
.minimal-light .esg-pagination-button:last-child { margin-right: 0; }
.minimal-light .esg-left, .minimal-light .esg-right	{ padding:0px 11px; }

.minimal-light  .esg-sortbutton-wrapper,
.minimal-light  .esg-cartbutton-wrapper { display:inline-block; }
.minimal-light  .esg-sortbutton-order,
.minimal-light  .esg-cartbutton-order {	display:inline-block;
										vertical-align:top;
										border:1px solid #e5e5e5;
										width:40px;
										line-height:38px;
										border-radius: 0px 5px 5px 0px;
										-moz-border-radius: 0px 5px 5px 0px;
										-webkit-border-radius: 0px 5px 5px 0px;
										font-size:12px;
										font-weight:700;
										color:#999;
										cursor: pointer;
										background:#fff;
									   }

.minimal-light .esg-cartbutton {
								color:#333;
								cursor: default !important;
								}
.minimal-light .esg-cartbutton .esgicon-basket {color:#333;
												font-size:15px;
												line-height:15px;
												margin-right:10px;
												}
.minimal-light  .esg-cartbutton-wrapper { cursor: default !important; }

.minimal-light .esg-sortbutton,
.minimal-light .esg-cartbutton { display:inline-block;
								position:relative;
								cursor: pointer;
								margin-right:0px;
								border-right:none;
								border-radius:5px 0px 0px 5px;
								-moz-border-radius:5px 0px 0px 5px;
								-webkit-border-radius:5px 0px 0px 5px;
								}

.minimal-light .esg-navigationbutton:hover,
.minimal-light .esg-filterbutton:hover,
.minimal-light .esg-sortbutton:hover,
.minimal-light .esg-sortbutton-order:hover,
.minimal-light .esg-cartbutton a:hover,
.minimal-light .esg-filterbutton.selected {
											background-color:#fff;
											border-color:#bbb;
											color:#333;
											box-shadow: 0px 3px 5px 0px rgba(0,0,0,0.13);
										  }

.minimal-light .esg-navigationbutton:hover * { color:#333; }

.minimal-light .esg-sortbutton-order.tp-desc:hover {
													border-color:#bbb;
													color:#333;
													box-shadow: 0px -3px 5px 0px rgba(0,0,0,0.13) !important;
												   }

.minimal-light .esg-filter-checked { 
									padding:1px 3px;
									color:#cbcbcb;
									background:#cbcbcb;
									margin-left:7px;
									font-size:9px;
									font-weight:300;
									line-height:9px;
									vertical-align: middle;
									}
.minimal-light .esg-filterbutton.selected .esg-filter-checked,
.minimal-light .esg-filterbutton:hover .esg-filter-checked {
															padding:1px 3px 1px 3px;
															color:#fff;
															background:#000;
															margin-left:7px;
															font-size:9px;
															font-weight:300;
															line-height:9px;
															vertical-align: middle;
														   }'),
  array('name' => 'Simple Light','handle' => 'simple-light','css' => '/******************************
	-	SIMPLE LIGHT SKIN	-
********************************/

.simple-light .navigationbuttons,
.simple-light .esg-pagination,
.simple-light .esg-filters { text-align: center; }

.simple-light .esg-filterbutton,
.simple-light .esg-navigationbutton,
.simple-light .esg-sortbutton,
.simple-light .esg-cartbutton a {
								color:#000;
								margin-right:5px;
								cursor:pointer;
								padding:0px 11px;
								border:1px solid #e5e5e5;
								line-height:30px;
								font-size:12px;
								font-weight:400;
								font-family:\\\\\\"Open Sans\\\\\\",sans-serif;
								display: inline-block;
								background:#eee;
								margin-bottom:5px;
							  }

.simple-light .esg-navigationbutton * {	color:#000; }
.simple-light .esg-left,
.simple-light .esg-right { color:#000; padding:0px 7px;}
.simple-light .esg-pagination-button:last-child { margin-right: 0; }

.simple-light .esg-sortbutton-wrapper,
.simple-light .esg-cartbutton-wrapper {	display:inline-block; }
.simple-light .esg-sortbutton-order,
.simple-light .esg-cartbutton-order {
									display: inline-block;
									vertical-align: top;
									border: 1px solid #e5e5e5;
									width: 29px;
									line-height: 30px;
									font-size: 9px;
									font-weight: 400;
									color: #000;
									cursor: pointer;
									background: #eee;
									}

.simple-light .esg-cartbutton {
								color:#333;
								cursor: default !important;
							  }
.simple-light .esg-cartbutton .esgicon-basket {
												color:#333;
												font-size:15px;
												line-height:15px;
												margin-right:10px;
											  }
.simple-light  .esg-cartbutton-wrapper { cursor: default !important; }

.simple-light .esg-sortbutton,
.simple-light .esg-cartbutton {
								display:inline-block;
								position:relative;
								cursor: pointer;
								margin-right:5px;
							  }


.simple-light .esg-navigationbutton:hover,
.simple-light .esg-filterbutton:hover,
.simple-light .esg-sortbutton:hover,
.simple-light .esg-sortbutton-order:hover,
.simple-light .esg-cartbutton a:hover,
.simple-light .esg-filterbutton.selected {
											background-color:#fff;
											border-color:#bbb;
											color:#333;
											box-shadow: 0px 3px 5px 0px rgba(0,0,0,0.13);
										 }

.simple-light .esg-navigationbutton:hover * { color:#333; }

.simple-light .esg-sortbutton-order.tp-desc:hover {
													border-color:#bbb;
													color:#333;
													box-shadow: 0px -3px 5px 0px rgba(0,0,0,0.13) !important;
												  }

.simple-light .esg-filter-checked {
									padding:3px;
									color:#c5c5c5;
									background:#ddd;
									margin-left:7px;
									font-size:9px;
									font-weight:400;
									line-height:20px;
									vertical-align: middle;
								  }
.simple-light .esg-filterbutton.selected .esg-filter-checked,
.simple-light .esg-filterbutton:hover .esg-filter-checked {
															padding: 3px;
															color:#fff;
															background:#000;
															margin-left:7px;
															font-size:9px;
															font-weight:400;
															line-height:20px;
															vertical-align: middle
														}'),
  array('name' => 'Simple Dark','handle' => 'simple-dark','css' => '/********************************
-	SIMPLE DARK BUTTONS -
*********************************/

.simple-dark .navigationbuttons,
.simple-dark .esg-pagination,
.simple-dark .esg-filters {	text-align: center; }

.simple-dark .esg-filterbutton,
.simple-dark .esg-navigationbutton,
.simple-dark .esg-sortbutton,
.simple-dark .esg-cartbutton {
								color:#fff;
								margin-right:5px;
								cursor:pointer;
								padding:0px 10px;
								border:1px solid rgb(255,255,255);
								border:1px solid rgba(255,255,255,0.15);
								line-height:29px;
								font-size:12px;
								font-weight:600;
								font-family:"Open Sans",sans-serif;
								display: inline-block;
								background: rgba(255,255,255,0.08 );
								margin-bottom:5px;
							  }

.simple-dark .esg-navigationbutton * {
										color:#fff;
									 }
.simple-dark .esg-left, .simple-dark .esg-right { padding:0px 5px !important; }

.simple-dark  .esg-sortbutton-wrapper,
.simple-dark  .esg-cartbutton-wrapper {	display:inline-block; }
.simple-dark  .esg-sortbutton-order,
.simple-dark  .esg-cartbutton-order {
									display: inline-block;
									vertical-align: top;
									border:1px solid rgb(255,255,255);
									border:1px solid rgba(255,255,255,0.15);
									width: 29px;
									line-height: 29px;
									font-size: 9px;
									font-weight: 600;
									color: #fff;
									cursor: pointer;
									background: rgba(255,255,255,0.08 );
									}

.simple-dark .esg-cartbutton {
							color:#fff;
							cursor: default !important;
							}
							
.simple-dark .esg-cartbutton .esgicon-basket {
												color:#fff;
												font-size:15px;
												line-height:15px;
												margin-right:10px;
											  }
.simple-dark  .esg-cartbutton-wrapper {	cursor: default !important; }

.simple-dark .esg-sortbutton,
.simple-dark .esg-cartbutton {
								display:inline-block;
								position:relative;
								cursor: pointer;
								margin-right:5px;
							  }


.simple-dark .esg-navigationbutton:hover,
.simple-dark .esg-filterbutton:hover,
.simple-dark .esg-sortbutton:hover,
.simple-dark .esg-sortbutton-order:hover,
.simple-dark .esg-cartbutton-order:hover,
.simple-dark .esg-filterbutton.selected {
										border-color:#fff;
										color:#000;
										box-shadow: 0px 3px 5px 0px rgba(0,0,0,0.13);
										background:#fff;
										}

.simple-dark .esg-navigationbutton:hover * { color:#000; }
.simple-dark .esg-pagination-button:last-child { margin-right: 0; }

.simple-dark .esg-sortbutton-order.tp-desc:hover {
													border-color:#fff;
													border-color:rgba(255,255,255,0.2);
													color:#000;
													box-shadow: 0px -3px 5px 0px rgba(0,0,0,0.13) !important;
												 }

.simple-dark .esg-filter-checked {
									padding:1px;
									color:transparent;
									background:#000;
									background: rgba(255,255,255,0.15);
									margin-left:7px;
									font-size:9px;
									font-weight:300;
									line-height:9px;
									vertical-align: middle;
								  }

.simple-dark .esg-filterbutton.selected .esg-filter-checked,
.simple-dark .esg-filterbutton:hover .esg-filter-checked {
															padding:1px;
															color:#000;
															background:#fff;
															margin-left:7px;
															font-size:9px;
															font-weight:300;
															line-height:9px;
															vertical-align: middle;
														  }'),
  array('name' => 'Text Dark','handle' => 'text-dark','css' => '/********************************
-	TEXT DARK BUTTONS -
*********************************/

.text-dark .navigationbuttons,
.text-dark .esg-pagination,
.text-dark .esg-filters { text-align: center; }

.text-dark .esg-filterbutton,
.text-dark .esg-navigationbutton,
.text-dark .esg-sortbutton,
.text-dark .esg-cartbutton {
							color:#fff;
							color:rgba(255,255,255,0.4);
							margin-right:5px;
							cursor:pointer;
							padding:0px 15px 0px 10px;
							line-height:20px;
							font-size:12px;
							font-weight:600;
							font-family:"Open Sans",sans-serif;
							display: inline-block;
							background:transparent;
							margin-bottom:5px;
						  }

.text-dark .esg-navigationbutton * {
									color:#fff;
									color:rgba(255,255,255,0.4);
								   }

.text-dark  .esg-sortbutton-wrapper,
.text-dark  .esg-cartbutton-wrapper { display:inline-block; }
.text-dark  .esg-sortbutton-order,
.text-dark  .esg-cartbutton-order {
									display: inline-block;
									vertical-align: middle;
									width: 29px;
									line-height: 20px;
									font-size: 9px;
									font-weight: 700;
									color:#fff;
									color:rgba(255,255,255,0.4);
									cursor: pointer;
									background: transparent;
								  }

.text-dark .esg-cartbutton {
							color:#fff;
							color:rgba(255,255,255,0.4);
							cursor: default !important;
							}
.text-dark .esg-cartbutton .esgicon-basket {
											color:#fff;
											color:rgba(255,255,255,0.4);
											font-size:15px;
											line-height:15px;
											margin-right:10px;
											}
.text-dark  .esg-cartbutton-wrapper { cursor: default !important; }

.text-dark .esg-sortbutton,
.text-dark .esg-cartbutton {
							display:inline-block;
							position:relative;
							cursor: pointer;
							margin-right:0px;
							}

.text-dark .esg-navigationbutton:hover,
.text-dark .esg-filterbutton:hover,
.text-dark .esg-sortbutton:hover,
.text-dark .esg-filterbutton.selected,
.text-dark .esg-sortbutton-order:hover,
.text-dark .esg-cartbutton-order:hover { color:#fff; }

.text-dark .esg-navigationbutton:hover,
.text-dark .esg-filterbutton:hover span:first-child,
.text-dark .esg-filterbutton.selected span:first-child { text-decoration: none; }

.text-dark .esg-filterbutton {
								border-right:1px solid #fff;
								border-right:1px solid rgba(255,255,255,0.15);
							  }
.text-dark .esg-filterbutton:last-child	{ border-right:none; }

.text-dark .esg-sortbutton-order {
									padding-left:10px;
									border-left:1px solid #fff;
									border-left:1px solid rgba(255,255,255,0.15);
								 }

.text-dark .esg-navigationbutton:hover * { color:#fff; }

.text-dark .esg-sortbutton-order.tp-desc:hover {
												border-color:#fff;
												border-color:rgba(255,255,255,0.15);
												color:#fff;
												}

.text-dark .esg-filter-checked {
								padding:1px 3px;
								color:transparent;
								background:#000;
								background: rgba(0,0,0,0.10);
								margin-left:7px;
								font-size:9px;
								font-weight:300;
								line-height:9px;
								vertical-align: middle;
								}

.text-dark .esg-filter-checked * { }
.text-dark .esg-filterbutton.selected .esg-filter-checked,
.text-dark .esg-filterbutton:hover .esg-filter-checked {
														padding:1px 3px 1px 3px;
														color:#fff;
														background:#000;
														background: rgba(0,0,0,0.10);
														margin-left:7px;
														font-size:9px;
														font-weight:300;
														line-height:9px;
														vertical-align: middle
														}'),
  array('name' => 'Text Light','handle' => 'text-light','css' => '/********************************
-	TEXT LIGHT BUTTONS -
*********************************/

.text-light .navigationbuttons,
.text-light .esg-pagination,
.text-light .esg-filters {
						text-align: center;
						position: relative;
						z-index:2;
						}

.text-light .esg-filterbutton,
.text-light .esg-navigationbutton,
.text-light .esg-sortbutton,
.text-light .esg-cartbutton {
							color:#999;
							margin-right:5px;
							cursor:pointer;
							padding:0px 15px 0px 10px;
							line-height:20px;
							font-size:12px;
							font-weight:600;
							font-family:"Open Sans",sans-serif;
							display: inline-block;
							background:transparent;
							margin-bottom:5px;
							}

.text-light .esg-navigationbutton * { color:#999; }

.text-light  .esg-sortbutton-wrapper,
.text-light  .esg-cartbutton-wrapper { display:inline-block; }
.text-light  .esg-sortbutton-order,
.text-light  .esg-cartbutton-order {
									display: inline-block;
									vertical-align: middle;
									width: 29px;
									line-height: 20px;
									font-size: 9px;
									font-weight: 700;
									color:#999;
									cursor: pointer;
									background: transparent;
									}

.text-light .esg-cartbutton {
							color:#999;
							cursor: default !important;
							}
.text-light .esg-cartbutton .esgicon-basket {
											color:#999;
											font-size:15px;
											line-height:15px;
											margin-right:10px;
											}
.text-light .esg-cartbutton-wrapper { cursor: default !important; }

.text-light .esg-sortbutton,
.text-light .esg-cartbutton {
							display:inline-block;
							position:relative;
							cursor: pointer;
							margin-right:0px;
							}

.text-light .esg-navigationbutton:hover,
.text-light .esg-filterbutton:hover,
.text-light .esg-sortbutton:hover,
.text-light .esg-filterbutton.selected,
.text-light .esg-sortbutton-order:hover,
.text-light .esg-cartbutton-order:hover { color:#444; }

.text-light .esg-navigationbutton:hover,
.text-light .esg-filterbutton:hover span:first-child,
.text-light .esg-filterbutton.selected span:first-child { text-decoration: underline; }

.text-light .esg-filterbutton {	border-right:1px solid #e5e5e5; }
.text-light .esg-filterbutton:last-child { border-right:none; }

.text-light .esg-sortbutton-order {
									padding-left:10px;
									border-left:1px solid #e5e5e5;
								  }

.text-light .esg-navigationbutton:hover * {	color:#444; }

.text-light .esg-sortbutton-order.tp-desc:hover {
												border-color:#e5e5e5;
												color:#444;
												}

.text-light .esg-filter-checked {
								padding:1px 3px;
								color:transparent;
								background:#eee;
								background: rgba(0,0,0,0.05);
								margin-left:7px;
								font-size:9px;
								font-weight:300;
								line-height:9px;
								vertical-align: middle;
								}
.text-light .esg-filter-checked * { }
.text-light .esg-filterbutton.selected .esg-filter-checked,
.text-light .esg-filterbutton:hover .esg-filter-checked {
														padding:1px 3px 1px 3px;
														color:#333;
														background:#eee;
														background: rgba(0,0,0,0.05);
														margin-left:7px;
														font-size:9px;
														font-weight:300;
														line-height:9px;
														vertical-align: middle;
														}
')
);

?>