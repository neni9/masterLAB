<?php

namespace App\Traits;


trait TraitHighcharts
{

	private $bgColor = '#fff';

	public function highcharts_column($title, $xCategories, $yTitle, $series)
	{
		$chart = [
            'chart' => ['type' => 'column'],
            'title' => ['text' => $title],
            'xAxis' => [
                'categories' => $xCategories,
            ],
            'yAxis' => [
                'title' => [
                    'text' => $yTitle
                ]
            ],
            'series' => $series,
            'colors'  => ['#986bff']
	    ];

        return $chart;
	}

	public function highcharts_stakcked_column($title,$categories,$yAxis,$series)
	{
		$chart = [
	        'chart' => [
	            'type' => 'column'
	        ],
	        'title' => [
	            'text' => $title
	        ],
	        'xAxis' => [
	            'categories' => $categories
	        ],
	        'yAxis' => [
	            'min' => 0,
	            'title' => [
	                'text' => $yAxis
	            ],
	            'stackLabels' => [
	                'enabled' => true,
	                'style' => [
	                    'fontWeight' => 'bold',
	                    'color' => 'gray'
	                ]
	            ]
	        ],
	        'legend' => [
	            'align' => 'right',
	            'x' => -30,
	            'verticalAlign' => 'top',
	            'y' => 25,
	            'floating' => true,
	            'backgroundColor' => 'white',
	            'borderColor' => '#CCC',
	            'borderWidth' => 1,
	            'shadow' => false
	        ],
	        'tooltip' => [
	            'headerFormat' => '<b>{point.x}</b><br/>',
	            'pointFormat' => '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
	        ],
	        'plotOptions' => [
	            'column' => [
	                'stacking' => 'normal',
	                'dataLabels' => [
	                    'enabled' => true,
	                    'color' => 'white',
	                    'style' => [
	                        'textShadow' => '0 0 3px black'
	                    ]
	                ]
	            ]
	        ],
	        'series' => $series
	    ];

	    return $chart;
	}
	public function highcharts_semi_donut($title,$series)
	{

		$chart = [
         	'chart' => [
         	    'plotBackgroundColor' => $this->bgColor,
         	    'plotBorderWidth' => 0,
         	    'plotShadow' => false
         	],
         	'title' => [
         	    'text' => $title,
         	    'align' => 'center',
         	    'verticalAlign' => 'middle',
         	    'y' => 40
         	],
         	'tooltip' => [
         	    'pointFormat' => ''
         	],
         	'plotOptions' => [
         	    'pie' => [
         	        'dataLabels' => [
         	            'enabled' => true,
         	            'distance' => -50,
         	            'style' => [
         	                'fontWeight' => 'bold',
         	                'color' => 'white',
         	                'textShadow' => '0px 1px 2px black'
         	            ]
         	        ],
         	        'startAngle' => -90,
         	        'endAngle' => 90,
         	        'center' => ['50%', '75%']
         	    ]
         	],
         	'series' => $series
        ];

        return $chart;
	}


	public function highcharts_fullcircle($title,$datas,$dataLabels)
	{
		$graph = [];
		
		$graph['chart'] = [

	        'chart' => [
	            'type' => 'solidgauge'
	        ],

	        'title' => null,

	        'pane' => [
	            'center' => ['50%', '50%'],
	            'size' => '100%',
	            'startAngle' => 0,
	            'endAngle' => 360,
	            'background' => [
	                'backgroundColor' => '#EEE',
	                'innerRadius' => '60%',
	                'outerRadius' => '100%',
	                'shape' => 'arc'
	            ]
	        ],

	        'tooltip' => [
	            'enabled' => false
	        ],

	        // the value axis
	        'yAxis' => [
	            'stops' => [
	                [0.1, '#7f52fb'], 
	                [0.5, '#6290fc'], 
	                [0.9, '#45cefd'] 
	            ],
	            'lineWidth' => 0,
	            'minorTickInterval' => null,
	            'tickPixelInterval' => 400,
	            'tickWidth' => 0,
	            'title' => [
	                'y' =>  -70
	            ],
	            'labels' => [
	                'enabled' => false
	            ]
	        ],

	        'plotOptions' => [
	            'solidgauge' => [
	                'dataLabels' => [
	                    'y' => -20,
	                    'borderWidth' => 0,
	                    'useHTML' => true
	                ]
	            ]
	        ]
	    ];

	    $graph['param'] = [
	        'yAxis' => [
	            'min' => 0,
	            'max' => 100,
	            'title' => [
	                'text' => $title
	            ]
	        ],

	        'credits' => [
	            'enabled' => false
	        ],

	        'series' => [[
	           'name' => $title,
	           'data' => $datas,
	           'dataLabels' => $dataLabels,
	            'tooltip' => [
	                'valueSuffix' => ' km/h'
	            ]
	        ]]
	       ];

	    

	    return $graph;
	}

	public function highcharts_pie($title,$series)
	{
		$chart = [
	        'chart' => [
	            'plotBackgroundColor' => null,
	            'plotBorderWidth' => null,
	            'plotShadow' => false,
	            'type' => 'pie'
	        ],
	        'title' => [
	            'text' => $title
	        ],
	        'tooltip' => [
	            'pointFormat' => '{series.name}: <b>{point.percentage:.1f}%</b>'
	        ],
	        'plotOptions' => [
	            'pie' => [
	                'allowPointSelect' => true,
	                'cursor' => 'pointer',
	                'dataLabels' => [
	                    'enabled' => true,
	                    'format' => '<b>{point.name}</b>: {point.percentage:.1f} %',
	                    'style' => [
	                        'color' => 'black'
	                    ],
	                    'connectorColor' => 'silver'
	                ]
	            ]
	        ],
	        'series' => $series
    	];

    	return $chart;
	}

}