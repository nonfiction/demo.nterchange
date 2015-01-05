default:
	@echo restore - clean environment from the snapshot folder
	@echo snapshot - save the current state as the restore point

.PHONY: snapshot
snapshot:
	@mysqldump -uroot -p'winning2011' nterchange_demo > snapshot/db.sql
	@rm -rf snapshot/upload.tgz && tar -czf snapshot/upload.tgz public_html/upload
