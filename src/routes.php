<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});

// get jenis kesenian
$app->get("/jeniskesenian/", function (Request $request, Response $response){
    $sql = "SELECT * FROM tb_jeniskesenian";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $response->withJson(["status" => "success", "data" => $result], 200);
});

// get kelurahan
$app->get("/kelurahan/", function (Request $request, Response $response){
    $sql = "SELECT * FROM tb_kelurahan";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $response->withJson(["status" => "success", "data" => $result], 200);
});

// get lingkunagan seni by kelurahan
$app->get("/lingkunganseni/kelurahan/{id}", function (Request $request, Response $response, $args){
    $id = $args["id"];
    $sql = "SELECT * FROM tb_lingkunganseni WHERE fk_kelurahan=:id";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([":id" => $id]);
    $result = $stmt->fetchAll();
    return $response->withJson(["status" => "success", "data" => $result], 200);
});

// get lingkunagan seni by jenis kesenian
$app->get("/lingkunganseni/jeniskesenian/", function (Request $request, Response $response, $args){
    $keyword = $request->getQueryParam("keyword");
    //$keyword = $keyword + ";";
    $sql = "SELECT * FROM tb_lingkunganseni WHERE tag_jeniskesenian LIKE '%$keyword%'";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $response->withJson(["status" => "success", "data" => $result], 200);
});

// get lingkunagan seni by kelurahan
// http://localhost:8080/lingkunganseni/id?key=
$app->get("/lingkunganseni/{id}", function (Request $request, Response $response, $args){
    $id = $args["id"];
    $sql = "SELECT * FROM tb_lingkunganseni WHERE id_lingkunganseni=:id";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([":id" => $id]);
    $result = $stmt->fetch();
    return $response->withJson(["status" => "success", "data" => $result], 200);
});

// search lingkunagan seni by name
// http://localhost:8080/lingkunganseni/search/?keyword=&key=
$app->get("/lingkunganseni/search/", function (Request $request, Response $response, $args){
    $keyword = $request->getQueryParam("keyword");
    //$keyword = $keyword + ";";
    $sql = "SELECT * FROM tb_lingkunganseni WHERE nama_lingkunganseni LIKE '%$keyword%'";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $response->withJson(["status" => "success", "data" => $result], 200);
});