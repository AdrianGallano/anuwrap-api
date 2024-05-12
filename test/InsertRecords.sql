INSERT INTO workspace (name) VALUES
('Workspace 1'),
('Workspace 2'),
('Workspace 3'),
('Workspace 4'),
('Workspace 5'),
('Workspace 6'),
('Workspace 7'),
('Workspace 8'),
('Workspace 9'),
('Workspace 10');

INSERT INTO user (username, first_name, last_name, email, password) VALUES
('user1', 'John', 'Doe', 'user1@example.com', 'password1'),
('user2', 'Jane', 'Smith', 'user2@example.com', 'password2'),
('user3', 'Alice', 'Johnson', 'user3@example.com', 'password3'),
('user4', 'Bob', 'Brown', 'user4@example.com', 'password4'),
('user5', 'Emily', 'Davis', 'user5@example.com', 'password5'),
('user6', 'Michael', 'Wilson', 'user6@example.com', 'password6'),
('user7', 'Sophia', 'Martinez', 'user7@example.com', 'password7'),
('user8', 'William', 'Anderson', 'user8@example.com', 'password8'),
('user9', 'Olivia', 'Taylor', 'user9@example.com', 'password9'),
('user10', 'James', 'Thomas', 'user10@example.com', 'password10');

INSERT INTO annualreport (title, description, workspace_id) VALUES
('Annual Report 1', 'Description for Annual Report 1', 1),
('Annual Report 2', 'Description for Annual Report 2', 2),
('Annual Report 3', 'Description for Annual Report 3', 1),
('Annual Report 4', 'Description for Annual Report 4', 2),
('Annual Report 5', 'Description for Annual Report 5', 1),
('Annual Report 6', 'Description for Annual Report 6', 2),
('Annual Report 7', 'Description for Annual Report 7', 1),
('Annual Report 8', 'Description for Annual Report 8', 2),
('Annual Report 9', 'Description for Annual Report 9', 1),
('Annual Report 10', 'Description for Annual Report 10', 2);

INSERT INTO collage (name, workspace_id) VALUES
('Collage 1', 1),
('Collage 2', 2),
('Collage 3', 1),
('Collage 4', 2),
('Collage 5', 1),
('Collage 6', 2),
('Collage 7', 1),
('Collage 8', 2),
('Collage 9', 1),
('Collage 10', 2);

INSERT INTO collageimage (path, collage_id) VALUES
('path/to/image1.jpg', 1),
('path/to/image2.jpg', 2),
('path/to/image3.jpg', 1),
('path/to/image4.jpg', 2),
('path/to/image5.jpg', 1),
('path/to/image6.jpg', 2),
('path/to/image7.jpg', 1),
('path/to/image8.jpg', 2),
('path/to/image9.jpg', 1),
('path/to/image10.jpg', 2);

INSERT INTO report (title, description, workspace_id) VALUES
('Report 1', 'Description for Report 1', 1),
('Report 2', 'Description for Report 2', 2),
('Report 3', 'Description for Report 3', 1),
('Report 4', 'Description for Report 4', 2),
('Report 5', 'Description for Report 5', 1),
('Report 6', 'Description for Report 6', 2),
('Report 7', 'Description for Report 7', 1),
('Report 8', 'Description for Report 8', 2),
('Report 9', 'Description for Report 9', 1),
('Report 10', 'Description for Report 10', 2);

INSERT INTO role (name) VALUES
('Role 1'),
('Role 2'),
('Role 3'),
('Role 4'),
('Role 5'),
('Role 6'),
('Role 7'),
('Role 8'),
('Role 9'),
('Role 10');

INSERT INTO userworkspace (user_id, workspace_id, role_id) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 1, 3),
(4, 2, 4),
(5, 1, 5),
(6, 2, 6),
(7, 1, 7),
(8, 2, 8),
(9, 1, 9),
(10, 2, 10);

INSERT INTO reportselection (annual_report_id, report_id) VALUES
(2, 1),
(3, 2),
(4, 3),
(5, 4),
(6, 5),
(7, 6),
(8, 7),
(9, 8),
(10, 9),
(11, 10);