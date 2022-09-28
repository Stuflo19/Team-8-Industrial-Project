UNLOCK TABLES;



#Make-Tables

CREATE TABLE exception (
    id serial4 NOT NULL,
    customer_id VARCHAR (20) NOT NULL,
    rule_id VARCHAR (20) NOT NULL,
    exception_value VARCHAR (50) NOT NULL,
    justification VARCHAR (80) NOT NULL,
    review_date timestamptz NOT NULL,
    last_updated timestamptz NOT NULL,
    last_updated_by VARCHAR (20) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (customer_id) REFERENCES customer(id),
    FOREIGN KEY (rule_id) REFERENCES rule(id),
    FOREIGN KEY (last_updated_by) REFERENCES user(id)
);
LOCK TABLE exception WRTIE;

UNLOCK TABLES;
CREATE TABLE non_compliance (
    id serial4 NOT NULL;
    resource_id VARCHAR (50) NOT NULL,
    rule_id VARCHAR (50) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (resource_id) REFERENCES resouce(id),
    FOREIGN KEY (rule_id) REFERENCES rule(id)
);
LOCK TABLE non_compliance WRITE;

CREATE TABLE platform (
    id VARCHAR (20) NOT NULL,
    PRIMARY KEY (id)
);
LOCK TABLE platform WRITE;

CREATE TABLE customer (
    id VARCHAR (20) NOT NULL,
    PRIMARY KEY (id)
);
LOCK TABLE customer WRITE;

CREATE TABLE user_role (
    id varchar (20) NOT NULL,
    PRIMARY KEY (id)
);
LOCK TABLE user_role WRITE;

CREATE TABLE resource_type (
    id VARCHAR(20) NOT NULL,
    platorm_id VARCHAR(20) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (platorm_id) REFERENCES platform(id)
);
LOCK TABLE resource_type WRITE;

CREATE TABLE account (
    id VARCHAR(20) NOT NULL,
    platorm_id VARCHAR(20) NOT NULL,
    customer_id VARCHAR(20) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (platorm_id) REFERENCES platform(id),
    FOREIGN KEY (customer_id) REFERENCES customer(id)
);
LOCK TABLE account WRITE;

CREATE TABLE user (
    id VARCHAR(20) NOT NULL,
    role_id VARCHAR (20) NOT NULL,
    customer_id VARCHAR(20) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (role_id) REFERENCES user_role(id),
    FOREIGN KEY (customer_id) REFERENCES customer(id)
);
LOCK TABLE user WRITE;

CREATE TABLE non_compliance_audit (
    id serial4 NOT NULL,
    non_compliance_id INT NOT NULL,
    resource_id VARCHAR (20) NOT NULL,
    rule_id VARCHAR (20) NOT NULL,
    user_id VARCHAR (20) NOT NULL,
    action VARCHAR (20) NOT NULL,
    action_dt timestamptz NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (resource_id) REFERENCES resouce(id),
    FOREIGN KEY (rule_id) REFERENCES rule(id),
    FOREIGN KEY (user_id) REFERENCES user(id)
);
LOCK TABLE non_compliance_audit WRITE;

CREATE TABLE exception_audit (
    id serial4 NOT NULL,
    exception_id int4 NOT NULL,
    user_id VARCHAR (20) NOT NULL,
    customer_id VARCHAR (20) NOT NULL,
    rule_id VARCHAR (20) NOT NULL,
    action VARCHAR (20) NOT NULL,
    action_dt timestamptz  NOT NULL,
    old_exception_value VARCHAR (100),
    new_exception_value VARCHAR (100),
    old_justification_value VARCHAR (100),
    new_justification_value VARCHAR (100),
    old_review_date timestamptz,
    new_review_date timestamptz,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES user(id),
    FOREIGN KEY (customer_id) REFERENCES customer(id)
);
LOCK TABLE exception_audit WRITE;

UNLOCK TABLES;

#Test-data-addition

INSERT INTO exception (id, customer_id, rule_id, exception_value, justification, review_date, last_updated, last_updated_by)
VALUES
    (1,"brightsolid","s3-detect-unencrypted-bucket","bs-quorum-dropbox","Enabled by system","2022-12-12 16:23:59.759 +0000","2022-09-12 17:25:36.091 +0100","system"),
    (3,"brightsolid","s3-detect-unencrypted-bucket","bsol-dev-bakery-assets","Enabled by system","2022-12-12 16:23:59.759 +0000","2022-09-12 17:25:36.091 +0100","system");

INSERT INTO non_compliance (id, resource_id, rule_id)
VALUES
    (1,"vol-0467a9dc3638c8e61",	"ebs-detect-unencrypted-volume"),
    (2,	"vol-0e181efd2ccb65947", "ebs-detect-unencrypted-volume"),
    (3,	"vol-0d589e5ded91a1aa2", "ebs-detect-unencrypted-volume"),
    (4,	"vol-0f1c53f6796a5fd3a", "ebs-detect-unencrypted-volume"),
    (5,	"brightsolid-website-infra-dev-ft-initial-dev-webroot",	"s3-detect-unauthorised-public-bucket"),
    (6,	"bs-website-scaling-test-webroot", "s3-detect-unauthorised-public-bucket"),
    (7,	"bs-website-test-blue-webroot",	"s3-detect-unauthorised-public-bucket"),
    (8,	"bsol-contract-web-hosting-test", "s3-detect-unauthorised-public-bucket"),
    (9,	"bsol-dev-tf-remotestate", "s3-detect-unauthorised-public-bucket"),
    (10, "custodian-console-dev-serverlessdeploymentbucket-t1pcg5tyd3i", "s3-detect-unauthorised-public-bucket"),
    (11, "website-devtest-webroot-backup", "s3-detect-unauthorised-public-bucket"),
    (12, "website-devtest-assets-backup", "s3-detect-unauthorised-public-bucket"),
    (13, "i-006d83e00aabe31d2", "ec2-detect-unauthorised-public-instance"),
    (14, "billptemp", "s3-detect-unencrypted-bucket"),
    (15, "brightsolid",	"s3-detect-unencrypted-bucket"),
    (16, "bs-quorum-dropbox", "s3-detect-unencrypted-bucket"),
    (17, "bsol-contract-web-hosting-test", "s3-detect-unencrypted-bucket"),
    (18, "bsol-dev-bakery-assets", "s3-detect-unencrypted-bucket"),
    (19, "bsol-dev-subnet-flowlogs", "s3-detect-unencrypted-bucket"),
    (20, "bsol-exception-test-no-customer-code2", "s3-detect-unencrypted-bucket"),
    (21, "bsol-test-no-customer-code2", "s3-detect-unencrypted-bucket"),
    (22, "dctdatarecovery", "s3-detect-unencrypted-bucket"),
    (23, "imustdestdeletions", "s3-detect-unencrypted-bucket");

