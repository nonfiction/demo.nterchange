default:
	@echo restore - clean environment from the snapshot folder
	@echo snapshot - save the current state as the restore point

.PHONY: snapshot
snapshot:
	@mysqldump -uroot -p nterchange_demo > snapshot/db.sql
	@rm -rf snapshot/upload.tgz && tar -czf snapshot/upload.tgz public_html/upload

.PHONY: restore
restore:
	@mysql -uroot -p nterchange_demo < snapshot/db.sql
	@sudo rm -rf public_html/upload
	@tar xzf snapshot/upload.tgz public_html/
	@sudo chown -R www-data:www-data public_html/upload
