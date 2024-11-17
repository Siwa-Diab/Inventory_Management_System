<?php
require('fpdf.php');

class PDF extends FPDF
{
    function __construct()
    {
        parent::__construct('L');
    }

    // Colored table
    function FancyTable($headers, $data)
    {
        // Colors, line width, and bold font
        $this->SetFillColor(255, 0, 0);
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(.3);
        $this->SetFont('', 'B');
        $width_sum = 0;
        foreach ($headers as $header_key => $header_data) {
            $this->Cell($header_data['width'], 7, $header_key, 1, 0, 'C', true);
            $width_sum += $header_data['width'];
        }

        $this->Ln();
        // Color and font restoration
        $this->SetTextColor(0);
        $this->SetFont('');
        // Data
        $img_pos_y = 40;
        $header_keys = array_keys($headers);
        foreach ($data as $row) {
            foreach ($header_keys as $header_key) {
                $content = $row[$header_key]['content'];
                $width = $headers[$header_key]['width'];
                $align = $row[$header_key]['align'];
                
                if ($header_key == 'image') {
                    $img_path = './IMAGES/' . $content;
                    if (file_exists($img_path) && exif_imagetype($img_path) == IMAGETYPE_PNG) {
                        $img_pos_y = $this->Image($img_path, 45, $img_pos_y, 30, 25);
                    } else {
                        $content = 'No Image';
                    }
                }

                $this->Cell($width, 30, $content, 'LRBT', 0, $align); //LRBT mean left right bottom top
            }
            $this->Ln();
            $img_pos_y += 30;
        }
        // Closing line
        $this->Cell($width_sum, 0, '', 'T');
    }
}

$type = $_GET['report'];
$report_headers = [
    'product' => 'Product Reports',
    'supplier' => 'Supplier Report',
    'purchase_orders' => 'Purchase Orders Report' // Added this line
];
$conn = mysqli_connect("localhost", "root", "", "inventory");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$data = [];

if ($type === 'product') {
    //columns headings-replace from MySQL database or hardcode it
    $headers = [
        'id' => [
            'width' => 15
        ],
        
        'product_name' => [
            'width' => 35
        ],
        'created_by' => [
            'width' => 30
        ],
        'created_at' => [
            'width' => 45
        ],
        'updated_at' => [
            'width' => 45
        ]
    ];
    //Load product
    $stmt = "SELECT products.id as pid, products.*, users.first_name, users.last_name FROM products
	  INNER JOIN
	  users ON 
	  products.created_by = users.id 
	  ORDER BY
	   products.created_at DESC";
    $res = mysqli_query($conn, $stmt);

    while ($products = mysqli_fetch_assoc($res)) {
        $products['created_by'] = $products['first_name'] . ' ' . $products['last_name'];
        unset($products['first_name'], $products['last_name'], $products['password'], $products['email'], $products['status']);
        
        // Append each row to the $data array
        $data[] = [
            'id' => [
                'content' => $products['pid'],
                'align' => 'C'
            ],
            'product_name' => [
                'content' => $products['product_name'],
                'align' => 'C' // mean center
            ],
            'created_by' => [
                'content' => $products['created_by'],
                'align' => 'L' //L means left
            ],
            'created_at' => [
                'content' => date('M d, Y h:i:s A', strtotime($products['created_at'])),
                'align' => 'L'
            ],
            'updated_at' => [
                'content' => date('M d, Y h:i:s A', strtotime($products['updated_at'])),
                'align' => 'L'
            ],
        ];
    }
}

if ($type === 'supplier') {
    //columns headings-replace from MySQL database or hardcode it
    $headers = [
        'supplier_id' => [
            'width' => 30,
             
        ],
        'created_at' => [
            'width' => 70
        ],
        'supplier_location' => [
            'width' => 50
        ],
        'email' => [
            'width' => 50
        ],
        'created_by' => [
            'width' => 50
        ]
    ];
    $stmt = "SELECT suppliers.id as sid,suppliers.created_at as 'created at',users.first_name,users.last_name,
    suppliers.supplier_location,suppliers.email,suppliers.created_by
     FROM suppliers INNER JOIN users ON suppliers.created_by = users.id ORDER BY suppliers.created_at DESC";
    $res = mysqli_query($conn, $stmt);

    while ($suppliers = mysqli_fetch_assoc($res)) {
        $suppliers['created_by'] = $suppliers['first_name'] . ' ' . $suppliers['last_name'];
        $data[] = [
            'supplier_id' => [
                'content' => $suppliers['sid'],
                'align' => 'C'
            ],
            'created_at' => [
                'content' => $suppliers['created at'],
                'align' => 'C'
            ],
            'supplier_location' => [
                'content' => $suppliers['supplier_location'],
                'align' => 'C'
            ],
            'email' => [
                'content' => $suppliers['email'],
                'align' => 'C'
            ],
            'created_by' => [
                'content' => $suppliers['created_by'],
                'align' => 'C'
            ]
        ];
    }
}

if ($type === 'purchase_orders') {
    $headers = [
        'id' => [
            'width' => 15,
             
        ],
        'quantity_ordered' => [
            'width' => 35
        ],
        'quantity_received' => [
            'width' => 35
        ],
        'quantity_remaining' => [
            'width' => 40
        ],
        'status' => [
            'width' => 30
        ],
        'batch' => [
            'width' => 30
        ],
        'supplier_name' => [
            'width' => 50
        ],
        'product_name' => [
            'width' => 50
        ],
        'order_product_created_at' => [
            'width' => 50
        ],
        'created_by' => [
            'width' => 40
        ]
    ];
    $stmt = "SELECT order_product.id, products.product_name, order_product.quantity_ordered, order_product.quantity_received,
     order_product.quantity_remaining, order_product.status, order_product.batch, users.first_name, users.last_name, suppliers.supplier_name,
     order_product.created_at as 'order_product_created_at' 
     FROM order_product 
     INNER JOIN users ON order_product.created_by = users.id
     INNER JOIN suppliers ON order_product.supplier = suppliers.id
     INNER JOIN products ON order_product.product = products.id
     ORDER BY order_product.batch DESC";
    $res = mysqli_query($conn, $stmt);
    while ($order_products = mysqli_fetch_assoc($res)) {
        $data[] = [
            'id' => [
                'content' => $order_products['id'],
                'align' => 'C'
            ],
            'quantity_ordered' => [
                'content' => $order_products['quantity_ordered'],
                'align' => 'C'
            ],
            'quantity_received' => [
                'content' => $order_products['quantity_received'],
                'align' => 'C'
            ],
            'quantity_remaining' => [
                'content' => $order_products['quantity_remaining'],
                'align' => 'C'
            ],
            'status' => [
                'content' => $order_products['status'],
                'align' => 'C'
            ],
            'batch' => [
                'content' => $order_products['batch'],
                'align' => 'C'
            ],
            'supplier_name' => [
                'content' => $order_products['supplier_name'],
                'align' => 'C'
            ],
            'product_name' => [
                'content' => $order_products['product_name'],
                'align' => 'C'
            ],
            'order_product_created_at' => [
                'content' => $order_products['order_product_created_at'],
                'align' => 'C'
            ],
            'created_by' => [
                'content' => $order_products['first_name'] . ' ' . $order_products['last_name'],
                'align' => 'C'
            ]
        ];
    }
}

// Start pdf
$pdf = new PDF();
$pdf->SetFont('Arial', '', 16);
$pdf->AddPage();
$pdf->Cell(0, 10, $report_headers[$type], 0, 1, 'C');
$pdf->Ln();
$pdf->SetFont('Arial', '', 10);
$pdf->FancyTable($headers, $data);
$pdf->Output();
?>
