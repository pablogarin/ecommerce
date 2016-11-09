<?php
$navs = array(
    'dashboard' => array(
        'url' => 'dashboard',
        'name' => 'Panel de Control',
        'current' => $current=='dashboard'
    ),
    'ventas' => array(
        'name' => 'Ventas',
        'navs' => array(
            "pedidos" => array(
                'url' => 'pedidos',
                'name' => 'Pedidos',
                'current' => $current=='pedidos'
            ),
            "modos-pago" => array(
                'url' => 'modos-pago',
                'name' => 'Modos de Pago',
                'current' => $current=='modos-pago'
            ),
            "costos-despacho" => array(
                'url' => 'costos-despacho',
                'name' => 'Costos de Despacho',
                'current' => $current=='costos-despacho'
            )
        )
    ),
    'catalogo' => array(
        'name' => 'Catalogo',
        'navs' => array(
            "categorias" => array(
                'url' => 'categorias',
                'name' => 'Categorias',
                'current' => $current=='categorias'
            ),
            /*
            "marcas" => array(
                'url' => 'marcas',
                'name' => 'Marcas',
                'current' => $current=='marcas'
            ),
            **/
            "productos" => array(
                'url' => 'productos',
                'name' => 'Productos',
                'current' => $current=='productos'
                /*
            ),
            "carga-masiva" => array(
                'url' => 'carga-masiva',
                'name' => 'Carga Masiva (Excel)',
                'current' => $current=='carga-masiva'
                //*/
            )
        )
    ),
    /*
    'promociones' => array(
        'name' => 'Promociones',
        'navs' => array(
            "giftcards" => array(
                'url' => 'giftcards',
                'name' => 'Giftcards',
                'current' => $current=='giftcards'
            )
        )
    ),
    //*/
    'contenido' => array(
        'name' => 'Contenido del Sitio (CMS)',
        'navs' => array(
            "home" => array(
                'url' => 'home',
                'name' => 'Home',
                'current' => $current=='home'
            ),
            "blog" => array(
                'url' => 'blog',
                'name' => 'Blog',
                'current' => $current=='blog'
            ),
            "textos" => array(
                'url' => 'textos',
                'name' => 'Textos',
                'current' => $current=='textos'
            ),
            /*
            "correos" => array(
                'url' => 'correos',
                'name' => 'Correos Autom&aacute;ticos',
                'current' => $current=='correos'
            ),
            //*/
            "configuraciones" => array(
                'url' => 'configuraciones',
                'name' => 'Configuraciones',
                'current' => $current=='configuraciones'
            )
        )
    )
);
foreach( $navs as $k=>$v ){
    if( isset( $v['navs'] ) ){
        $navs[$k]['active'] = in_array($current, array_keys($v['navs']));
    }
}
