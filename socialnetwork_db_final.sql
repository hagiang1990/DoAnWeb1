-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 27, 2019 lúc 04:21 AM
-- Phiên bản máy phục vụ: 10.4.8-MariaDB
-- Phiên bản PHP: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `socialnetwork_db`
--

DELIMITER $$
--
-- Thủ tục
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_LoadNewFeed` (IN `UserID` INT, IN `StartPage` INT, IN `LimitRow` INT)  NO SQL
SELECT n.*, u.FullName,u.ImageUrl as UserImage ,
(SELECT COUNT(*) FROM newfeed_like nl WHERE n.NewFeedID = nl.NewFeedID) AS NumLike
FROM newfeeds as n  
	join users as u  
		on n.CreatedUser = u.UserID 
WHERE ( 
    	u.UserID = UserID
       	OR EXISTS (select * from users_friends as uf where (u.UserID = uf.UserID OR u.UserID = uf.FriendID ) AND uf.IsFollow = 1 AND uf.IsAccept = 1)
       )
AND n.IsPrivate in (0,1)
AND n.IsDeleted = 0
ORDER BY n.CreatedDate DESC
LIMIT StartPage,LimitRow$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comments`
--

CREATE TABLE `comments` (
  `CommentID` int(11) NOT NULL,
  `ParentCommentID` int(11) NOT NULL,
  `CommentContent` longtext COLLATE utf8_bin NOT NULL,
  `NewFeedID` int(11) NOT NULL,
  `IsDeleted` tinyint(1) NOT NULL DEFAULT 0,
  `CreatedUser` int(11) NOT NULL,
  `CreatedDate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Đang đổ dữ liệu cho bảng `comments`
--

INSERT INTO `comments` (`CommentID`, `ParentCommentID`, `CommentContent`, `NewFeedID`, `IsDeleted`, `CreatedUser`, `CreatedDate`) VALUES
(1, 0, 'Comment số 1', 13, 0, 1, '2019-12-23 22:50:51'),
(2, 0, 'Comment 22342', 10, 0, 1, '2019-12-23 22:51:08'),
(3, 0, 'comment mới', 10, 0, 3, '2019-12-26 05:43:11'),
(4, 0, 'Comment ', 12, 0, 1, '2019-12-27 10:03:58'),
(5, 0, 'Comment 2131', 16, 0, 1, '2019-12-27 10:07:38'),
(6, 0, 'Comment 2131', 16, 0, 1, '2019-12-27 10:07:43'),
(7, 0, '121312121', 16, 0, 1, '2019-12-27 10:08:38'),
(8, 0, '12131', 12, 0, 1, '2019-12-27 10:09:49'),
(9, 0, 'fffff', 16, 0, 1, '2019-12-27 10:09:55'),
(10, 0, '12121', 16, 0, 1, '2019-12-27 10:10:49'),
(11, 0, 'đfdđ', 16, 0, 1, '2019-12-27 10:12:10'),
(12, 0, '12131', 12, 0, 1, '2019-12-27 10:12:39'),
(13, 0, '222222', 12, 0, 1, '2019-12-27 10:13:48'),
(14, 0, 'like', 16, 0, 3, '2019-12-27 10:14:36');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `messeger`
--

CREATE TABLE `messeger` (
  `MessegerID` int(11) NOT NULL,
  `FromUserID` int(11) NOT NULL,
  `ToUserID` int(11) NOT NULL,
  `CreatedDate` datetime NOT NULL DEFAULT current_timestamp(),
  `IsDeleted` tinyint(1) NOT NULL DEFAULT 0,
  `CreatedUser` int(11) NOT NULL,
  `HiddenToUser` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Người nhận ẩn nội dung tin nhắn'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `messegerdetail`
--

CREATE TABLE `messegerdetail` (
  `MessegerDetailID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Content` int(11) NOT NULL,
  `CreatedDate` datetime NOT NULL DEFAULT current_timestamp(),
  `IsDeleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `newfeeds`
--

CREATE TABLE `newfeeds` (
  `NewFeedID` int(11) NOT NULL,
  `NewFeedContent` text COLLATE utf8_bin NOT NULL,
  `UrlImage` varchar(1000) COLLATE utf8_bin NOT NULL,
  `IsPrivate` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 - Public , 1- Bạn Bè , -1 - Private',
  `CreatedDate` datetime NOT NULL DEFAULT current_timestamp(),
  `IsDeleted` tinyint(1) NOT NULL DEFAULT 0,
  `CreatedUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Đang đổ dữ liệu cho bảng `newfeeds`
--

INSERT INTO `newfeeds` (`NewFeedID`, `NewFeedContent`, `UrlImage`, `IsPrivate`, `CreatedDate`, `IsDeleted`, `CreatedUser`) VALUES
(1, 'test', 'background.jpg', 0, '2019-12-17 22:50:42', 1, 1),
(2, 'Thông tin ban đầu, vào khoảng 11h20 cùng ngày, xe buýt số 8 chạy tuyến bến xe quận 8 – Đại học Quốc gia TP.HCM vừa tấp vào trạm trước trung tâm thương mại trên đại lộ Phạm Văn Đồng để đón trả khách thì bị nhóm thanh niên cầm hung khí đứng vây quanh.', '1577010889.png', 0, '2019-12-22 17:34:49', 0, 1),
(3, 'Online comments systems and chat applications will not be complete without an option to insert emojis. Emojis are emotive images to share emotions while sending messages. The Facebook-like social media websites popularized the usage of emoji by providing the messaging interface with emoji support.\n\nGenerally, people share emotions by creating emojis with symbols for example :-) ;-). By having the graphical emotive icons, it is fun to convey a variety of emotions through messages easily.', '1577012459.jpg', 0, '2019-12-22 18:00:59', 0, 1),
(4, 'Cụ thể, ở ngay phần đầu của đề thi cuối kỳ này, giảng viên đã cẩn thận ghi hướng dẫn cho sinh viên: \"Crying is allowed but please do so quietly. Do not wipe tears on exam paper (tạm dịch: Khóc cũng được nhưng nhỏ tiếng thôi. Không được lau nước mắt bằng giấy thi).', '1577012549.png', 0, '2019-12-22 18:02:29', 0, 1),
(5, 'Xe ga 2020 Yamaha Fascino 125 về đại lý, giá 21,64 triệu đồng', '', 0, '2019-12-22 18:10:55', 1, 1),
(6, 'Xe ga 2020 Yamaha Fascino 125 về đại lý, giá 21,64 triệu đồng\n', '1577013538.jpg', 0, '2019-12-22 18:18:58', 0, 1),
(7, '2020 Yamaha Fascino 125 Fi có cả phiên bản phanh đĩa và phanh trống. Xe đặc biệt có nhiều màu sắc lựa chọn, phù hợp với thị hiếu tiêu dùng của nhiều người, bao gồm các màu như màu đỏ, màu đen, màu vàng, màu xanh da trời, màu xanh đen, màu vàng đồng và màu xanh lục lam.\n\nCó thể nói, 2020 Yamaha Fascino 125 Fi có những nét gợi nhắc tới dòng xe Yamaha Grande bán tại thị trường Việt Nam. Tất nhiên nếu ở tầm giá 21,64 triệu VNĐ thì ở thị trường Việt Nam khó mà tìm được một sản phẩm xe tay ga nào như Fascino ở Ấn Độ.', '1577013595.jpg', 0, '2019-12-22 18:19:55', 0, 1),
(8, '1213121', '1577020622.jpg', 1, '2019-12-22 20:17:02', 0, 1),
(9, '123121212121123', '1577020773.png', 0, '2019-12-22 20:19:33', 0, 1),
(10, '[BÀI 24] CHỨC NĂNG PHÂN TRANG TRONG PHP', '1577023525.png', 0, '2019-12-22 21:05:25', 0, 1),
(11, 'Con gà con', '1577028897.jpg', 0, '2019-12-22 22:34:57', 0, 3),
(12, 'Bài số 2', '1577031690.jpg', 0, '2019-12-22 23:21:30', 0, 3),
(13, '121212', '', 0, '2019-12-22 23:30:52', 1, 3),
(14, 'đăng bài 1', '', 0, '2019-12-27 10:03:16', 1, 1),
(15, 'bài số 2', '', 0, '2019-12-27 10:03:34', 1, 1),
(16, 'fdfdfdsfsfsdfsfs121121213dewadad', '1577416048.png', 0, '2019-12-27 10:07:28', 0, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `newfeed_like`
--

CREATE TABLE `newfeed_like` (
  `NewFeedID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Đang đổ dữ liệu cho bảng `newfeed_like`
--

INSERT INTO `newfeed_like` (`NewFeedID`, `UserID`) VALUES
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(11, 1),
(11, 3),
(13, 1),
(16, 3);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `FullName` text COLLATE utf8_bin NOT NULL,
  `Email` varchar(500) COLLATE utf8_bin NOT NULL,
  `Pwd` varchar(500) COLLATE utf8_bin NOT NULL,
  `Phone` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `DOB` date DEFAULT NULL,
  `ImageUrl` varchar(1000) COLLATE utf8_bin NOT NULL,
  `ImagePage` varchar(4000) COLLATE utf8_bin NOT NULL,
  `IsActived` tinyint(1) NOT NULL DEFAULT 0,
  `ActivedCode` varchar(20) COLLATE utf8_bin NOT NULL,
  `ActivedDate` datetime NOT NULL,
  `CreatedDate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`UserID`, `FullName`, `Email`, `Pwd`, `Phone`, `DOB`, `ImageUrl`, `ImagePage`, `IsActived`, `ActivedCode`, `ActivedDate`, `CreatedDate`) VALUES
(1, 'Hà Giang', 'ck.hagiang@gmail.com', '123456', '090000000', '1991-12-19', '1576417287.jpg', '', 1, '', '2019-12-03 00:00:00', '2019-12-14 09:55:19'),
(3, 'Phạm Trung Tấn', 'tanphamtrung1991@gmail.com', '123456', '0906644235', NULL, '1577028854.jpg', '', 1, '9XJwg', '0000-00-00 00:00:00', '2019-12-22 22:32:08'),
(4, 'Văn A', 'acb@gmail.com', '123456', '0906644235', NULL, 'noavatar.png', '', 1, '9XJwg', '2019-12-17 00:00:00', '2019-12-22 22:32:08');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users_friends`
--

CREATE TABLE `users_friends` (
  `UserID` int(11) NOT NULL,
  `FriendID` int(11) NOT NULL,
  `IsAccept` tinyint(4) NOT NULL DEFAULT 0,
  `DateAccept` datetime NOT NULL,
  `IsFollow` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Đang đổ dữ liệu cho bảng `users_friends`
--

INSERT INTO `users_friends` (`UserID`, `FriendID`, `IsAccept`, `DateAccept`, `IsFollow`) VALUES
(1, 3, 1, '2019-12-22 00:00:00', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users_notifications`
--

CREATE TABLE `users_notifications` (
  `NotificationID` int(11) NOT NULL,
  `FromUserID` int(11) NOT NULL,
  `ToUserID` int(11) NOT NULL,
  `NotificationType` int(11) NOT NULL DEFAULT 0 COMMENT '0 - Yêu cầu kết bạn, 1 - Có tin nhắn , 2- Có người vừa like ảnh',
  `ShortDescription` text COLLATE utf8_bin NOT NULL,
  `CreatedDate` datetime NOT NULL DEFAULT current_timestamp(),
  `IsComplete` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Đang đổ dữ liệu cho bảng `users_notifications`
--

INSERT INTO `users_notifications` (`NotificationID`, `FromUserID`, `ToUserID`, `NotificationType`, `ShortDescription`, `CreatedDate`, `IsComplete`) VALUES
(1, 3, 1, 2, 'Bình Luận nội dung bài viết của bạn.', '2019-12-26 05:43:11', 0),
(2, 1, 3, 2, 'thích nội dung bài viết của bạn.', '2019-12-26 05:43:56', 0),
(3, 1, 3, 2, 'Bình Luận nội dung bài viết của bạn.', '2019-12-27 10:03:58', 0),
(4, 1, 3, 2, 'thích nội dung bài viết của bạn.', '2019-12-27 10:04:11', 0),
(5, 1, 3, 2, 'Bình Luận nội dung bài viết của bạn.', '2019-12-27 10:09:49', 0),
(6, 1, 3, 2, 'Bình Luận nội dung bài viết của bạn.', '2019-12-27 10:13:48', 0),
(7, 3, 1, 2, 'thích nội dung bài viết của bạn.', '2019-12-27 10:14:29', 0),
(8, 3, 1, 2, 'Bình Luận nội dung bài viết của bạn.', '2019-12-27 10:14:36', 0);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`CommentID`);

--
-- Chỉ mục cho bảng `messeger`
--
ALTER TABLE `messeger`
  ADD PRIMARY KEY (`MessegerID`);

--
-- Chỉ mục cho bảng `messegerdetail`
--
ALTER TABLE `messegerdetail`
  ADD PRIMARY KEY (`MessegerDetailID`);

--
-- Chỉ mục cho bảng `newfeeds`
--
ALTER TABLE `newfeeds`
  ADD PRIMARY KEY (`NewFeedID`);

--
-- Chỉ mục cho bảng `newfeed_like`
--
ALTER TABLE `newfeed_like`
  ADD PRIMARY KEY (`NewFeedID`,`UserID`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`);

--
-- Chỉ mục cho bảng `users_friends`
--
ALTER TABLE `users_friends`
  ADD PRIMARY KEY (`UserID`,`FriendID`);

--
-- Chỉ mục cho bảng `users_notifications`
--
ALTER TABLE `users_notifications`
  ADD PRIMARY KEY (`NotificationID`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `comments`
--
ALTER TABLE `comments`
  MODIFY `CommentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `messeger`
--
ALTER TABLE `messeger`
  MODIFY `MessegerID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `messegerdetail`
--
ALTER TABLE `messegerdetail`
  MODIFY `MessegerDetailID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `newfeeds`
--
ALTER TABLE `newfeeds`
  MODIFY `NewFeedID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `users_notifications`
--
ALTER TABLE `users_notifications`
  MODIFY `NotificationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
