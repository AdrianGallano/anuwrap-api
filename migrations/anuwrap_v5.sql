CREATE TABLE IF NOT EXISTS Workspace (
    workspace_id int(10) UNSIGNED NOT NULL AUTO_INCREMENT, 
    name varchar(100) NOT NULL, date_modified timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(), date_created timestamp NOT NULL DEFAULT current_timestamp(), PRIMARY KEY (workspace_id), KEY name (name)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS AnnualReport (
    annual_report_id int(10) UNSIGNED NOT NULL AUTO_INCREMENT, annualreport_title varchar(100) NOT NULL, description text DEFAULT NULL, workspace_id int(10) UNSIGNED DEFAULT NULL, date_modified timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(), date_created timestamp NOT NULL DEFAULT current_timestamp(), PRIMARY KEY (annual_report_id), KEY annualreport_title (annualreport_title), CONSTRAINT FK_annualreport_workspace FOREIGN KEY (workspace_id) REFERENCES Workspace (workspace_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS ReportType (
    report_type_id int(10) UNSIGNED NOT NULL AUTO_INCREMENT, name varchar(100) NOT NULL, PRIMARY KEY (report_type_id), KEY name (name)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS Collage (
    collage_id int(10) UNSIGNED NOT NULL AUTO_INCREMENT, date_created timestamp NOT NULL DEFAULT current_timestamp(), date_modified timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(), name varchar(100) NOT NULL, workspace_id int(10) UNSIGNED DEFAULT NULL, PRIMARY KEY (collage_id), KEY workspace_id (workspace_id), CONSTRAINT FK_collage_workspace FOREIGN KEY (workspace_id) REFERENCES Workspace (workspace_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS CollageImage (
    collage_image_id int(10) UNSIGNED NOT NULL AUTO_INCREMENT, path text NOT NULL, collage_id int(10) UNSIGNED DEFAULT NULL, PRIMARY KEY (collage_image_id), KEY collage_id (collage_id), CONSTRAINT FK_collageimage_collage FOREIGN KEY (collage_id) REFERENCES Collage (collage_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS Report (
    report_id int(10) UNSIGNED NOT NULL AUTO_INCREMENT, 
    title varchar(100) NOT NULL, 
    report_type_id int(10) UNSIGNED DEFAULT NULL, 
    workspace_id int(10) UNSIGNED DEFAULT NULL, 
    date_modified timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(), 
    date_created timestamp NOT NULL DEFAULT current_timestamp(), 
    PRIMARY KEY (report_id), 
    KEY workspace_id (workspace_id), 
    KEY title (title),
    CONSTRAINT FK_report_workspace FOREIGN KEY (workspace_id) REFERENCES Workspace (workspace_id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT FK_report_report_type FOREIGN KEY (report_type_id) REFERENCES ReportType (report_type_id) ON DELETE CASCADE ON UPDATE CASCADE


) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS ReportSelection (
    annual_report_id int(10) UNSIGNED NOT NULL, report_id int(10) UNSIGNED NOT NULL, PRIMARY KEY (annual_report_id, report_id), KEY report_id (report_id), CONSTRAINT FK_reportselection_annualreport FOREIGN KEY (annual_report_id) REFERENCES AnnualReport (annual_report_id) ON DELETE CASCADE ON UPDATE CASCADE, CONSTRAINT FK_reportselection_report FOREIGN KEY (report_id) REFERENCES Report (report_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS Role (
    role_id int(10) UNSIGNED NOT NULL AUTO_INCREMENT, name varchar(50) NOT NULL, PRIMARY KEY (role_id), KEY name (name)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS User (
    user_id int(10) UNSIGNED NOT NULL AUTO_INCREMENT, 
    username varchar(50) NOT NULL, 
    first_name varchar(50) NOT NULL, 
    last_name varchar(50) NOT NULL, 
    email tinytext NOT NULL, password varchar(60) NOT NULL, 
    status TINYINT(1) NOT NULL,
    image_name TEXT NOT NULL,
    PRIMARY KEY (user_id), UNIQUE KEY username_unique (username), 
    UNIQUE KEY email_unique (email (100)) USING HASH, KEY username (username), KEY email (email (255))
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS UserWorkspace (
    user_id int(10) UNSIGNED NOT NULL, workspace_id int(10) UNSIGNED NOT NULL, role_id int(10) UNSIGNED DEFAULT NULL, PRIMARY KEY (user_id, workspace_id), KEY workspace_id (workspace_id), KEY role_id (role_id), CONSTRAINT FK_userworkspace_user FOREIGN KEY (user_id) REFERENCES User (user_id) ON DELETE CASCADE ON UPDATE CASCADE, CONSTRAINT FK_userworkspace_workspace FOREIGN KEY (workspace_id) REFERENCES Workspace (workspace_id) ON DELETE CASCADE ON UPDATE CASCADE, CONSTRAINT FK_userworkspace_role FOREIGN KEY (role_id) REFERENCES Role (role_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS FacultyMatrix (
    faculty_matrix_id int(10) UNSIGNED NOT NULL AUTO_INCREMENT, 
    name VARCHAR(100) NOT NULL, 
    position VARCHAR(100) NOT NULL, 
    tenure VARCHAR(50), status TINYINT(1) NOT NULL, 
    related_certificate VARCHAR(100), 
    doctorate_degree VARCHAR(100), 
    masters_degree VARCHAR(100), 
    baccalaureate_degree VARCHAR(100), 
    specification VARCHAR(255), 
    enrollment_status VARCHAR(255), 
    designation VARCHAR(100), 
    teaching_experience INT, 
    organization_membership VARCHAR(255), 
    report_id INT(10) UNSIGNED NOT NULL, 
    PRIMARY KEY (faculty_matrix_id), KEY 
    report_id (report_id), CONSTRAINT FK_facultymatrix_report FOREIGN KEY (report_id) REFERENCES Report (report_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;


CREATE TABLE IF NOT EXISTS AccomplishmentReport (
    accomplishment_report_id int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    name_of_activity VARCHAR(100) NOT NULL,
    date_of_activity DATE NOT NULL,
    venue_of_activity VARCHAR(100) NOT NULL,
    nature_of_activity VARCHAR(100) NOT NULL,
    benefits_of_the_participants VARCHAR(100) NOT NULL,
    narrative_report TEXT NOT NULL,
    image_name TEXT,
    report_id INT(10) UNSIGNED NOT NULL,
    PRIMARY KEY (accomplishment_report_id),
    KEY report_id (report_id),
    CONSTRAINT FK_accomplishmentreport_report FOREIGN KEY (report_id) REFERENCES Report (report_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;


INSERT IGNORE INTO
    Role (role_id, name)
VALUES (1, 'superadmin'),
    (2, 'admin'),
    (3, 'User');

INSERT IGNORE INTO
    ReportType (report_type_id, name)
VALUES (1, 'Faculty Matrix'),
    (2, 'Accomplishment Report');