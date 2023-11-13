# External Module API Demo

An example module to demonstrate module API services through the `redcap_module_api` hook.

## The API

This demo provides a simple API for managing a list. List items can be
- added (`add-item`, returning _item-id_)
- read back (`get-item`, requiring _item-id_, returning _item-id_ and _item-name_)
- listed (`list-items`)
- removed (`remove-item`, requiring _item-id_)

Items are stored in the module logs. This demo only supports `json` as return format.

## CURL requests

To try this out, replace **dev-redcap** with the URL of a REDCap server where this module is installed, and **API_TOKEN** with an appropriate token.  
Furthermore, replace **ID** with an actual id returned in the responses.

### 1. Add an item

```
curl --request POST \
  --url https://dev-redcap/api/ \
  --header 'content-type: application/x-www-form-urlencoded' \
  --header 'user-agent: vscode-restclient' \
  --data content=externalModule \
  --data prefix=em_api_demo \
  --data token=API_TOKEN \
  --data returnFormat=json \
  --data action=add-item \
  --data 'item-name=My first item!'
```

### 2. Add another item

```
curl --request POST \
  --url https://dev-redcap/api/ \
  --header 'content-type: application/x-www-form-urlencoded' \
  --header 'user-agent: vscode-restclient' \
  --data content=externalModule \
  --data prefix=em_api_demo \
  --data token=API_TOKEN \
  --data returnFormat=json \
  --data action=add-item \
  --data 'item-name=My second item!'
```


### 3. List the items

```
curl --request POST \
  --url https://dev-redcap/api/ \
  --header 'content-type: application/x-www-form-urlencoded' \
  --header 'user-agent: vscode-restclient' \
  --data content=externalModule \
  --data prefix=em_api_demo \
  --data token=API_TOKEN \
  --data returnFormat=json \
  --data action=list-items
```

### 4. Get an item

```
curl --request POST \
  --url https://dev-redcap/api/ \
  --header 'content-type: application/x-www-form-urlencoded' \
  --header 'user-agent: vscode-restclient' \
  --data content=externalModule \
  --data prefix=em_api_demo \
  --data token=API_TOKEN \
  --data returnFormat=json \
  --data action=get-item \
  --data item-id=<INSERT-ITEM-ID>
```

### 5. Remove an item

```
curl --request POST \
  --url https://dev-redcap/api/ \
  --header 'content-type: application/x-www-form-urlencoded' \
  --header 'user-agent: vscode-restclient' \
  --data content=externalModule \
  --data prefix=em_api_demo \
  --data token=API_TOKEN \
  --data returnFormat=json \
  --data action=remove-item \
  --data item-id=<INSERT-ITEM-ID>
```

### 6. List the items

```
curl --request POST \
  --url https://dev-redcap/api/ \
  --header 'content-type: application/x-www-form-urlencoded' \
  --header 'user-agent: vscode-restclient' \
  --data content=externalModule \
  --data prefix=em_api_demo \
  --data token=API_TOKEN \
  --data returnFormat=json \
  --data action=list-items
```
