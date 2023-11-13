<?php namespace DE\RUB\ApiDemoExternalModule;

use ExternalModules\AbstractExternalModule;

class ApiDemoExternalModule extends AbstractExternalModule {

    const ITEM_STORE = "MyItemStore";

    function redcap_module_api($action, $payload, $project_id, $user_id, $format, $returnFormat, $csvDelim) {
        if ($returnFormat != "json") {
            return $this->framework->apiErrorResponse("This API only supports JSON as return format!", 400);
        }
        switch ($action) {
            case "get-item": return $this->get_item($payload);
            case "list-items": return $this->list_items();
            case "add-item": return $this->add_item($payload);
            case "remove-item": return $this->remove_item($payload);
        }
    }

    function add_item($payload) {
        $name = "". ($payload["item-name"] ?? "");
        if ($name == "") return $this->framework->apiErrorResponse("Must specify 'item-name'!", 400);
        $id = \Crypto::getGuid();
        $this->framework->log(self::ITEM_STORE, [
            "id" => $id,
            "name" => $name
        ]);
        return $this->framework->apiJsonResponse([
            "item-id" => $id
        ]);
    }

    function get_item($payload) {
        $id = "". ($payload["item-id"] ?? "");
        if ($id == "") return $this->framework->apiErrorResponse("Must specify 'item-id'!", 400);
        $result = $this->framework->queryLogs("SELECT name WHERE message = ? AND id = ?", [self::ITEM_STORE, $id]);
        while ($row = $result->fetch_assoc()) {
            return $this->framework->apiJsonResponse([
                "item-id" => $id,
                "item-name" => $row["name"]
            ]);
        }
        return $this->framework->apiErrorResponse("Could not find item with id '$id'.", 404);
    }

    function list_items() {
        $list = [];
        $result = $this->framework->queryLogs("SELECT id, name WHERE message = ?", [self::ITEM_STORE]);
        while ($row = $result->fetch_assoc()) {
            $list[] = [
                "item-id" => $row["id"],
                "item-name" => $row["name"]
            ];
        }
        return $this->framework->apiJsonResponse($list);
    }

    function remove_item($payload) {
        $id = "". ($payload["item-id"] ?? "");
        if ($id == "") return $this->framework->apiErrorResponse("Must specify 'item-id'!", 400);
        $result = $this->framework->queryLogs("SELECT 1 WHERE message = ? AND id = ?", [self::ITEM_STORE, $id]);
        if ($result->num_rows !== 1) {
            return $this->framework->apiErrorResponse("No item with id '$id'.", 404);
        }
        else {
            $this->framework->removeLogs("message = ? AND id = ?", [
                self::ITEM_STORE, $id
            ]);
        }
        return $this->framework->apiResponse(); // Could be null or void
    }
}