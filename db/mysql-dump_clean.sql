-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 27, 2024 at 06:01 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mysql-dump`
--

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `tribe_id` int(11) NOT NULL,
  `article_title` varchar(50) NOT NULL,
  `leader_id` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(150) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attempts`
--

CREATE TABLE `attempts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `attempts` tinyint(4) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comment_likes`
--

CREATE TABLE `comment_likes` (
  `id` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_dislike` int(11) NOT NULL DEFAULT 0,
  `is_like` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `discussions`
--

CREATE TABLE `discussions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `parent_comment_id` int(11) NOT NULL DEFAULT 0,
  `article_id` int(11) NOT NULL,
  `comment` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `join_requests`
--

CREATE TABLE `join_requests` (
  `id` int(11) NOT NULL,
  `is_declined` tinyint(4) NOT NULL DEFAULT 0,
  `tribe_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `login_securities`
--

CREATE TABLE `login_securities` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `google2fa_enable` tinyint(1) NOT NULL DEFAULT 0,
  `google2fa_secret` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `mediatype` text NOT NULL,
  `media` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `media_types`
--

CREATE TABLE `media_types` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `mediatype` text NOT NULL,
  `file` varchar(255) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2020_10_02_133027_create_tribes_table', 1),
(2, '2020_10_03_155050_create_user_tribes_table', 1),
(3, '2020_10_03_171709_create_users_table', 2),
(4, '2020_10_05_105958_create_question_answers_table', 3),
(5, '2020_10_05_110028_create_topics_table', 3),
(6, '2020_10_05_110056_create_user_questions_table', 3),
(7, '2016_06_01_000001_create_oauth_auth_codes_table', 4),
(8, '2016_06_01_000002_create_oauth_access_tokens_table', 4),
(9, '2016_06_01_000003_create_oauth_refresh_tokens_table', 4),
(10, '2016_06_01_000004_create_oauth_clients_table', 4),
(11, '2016_06_01_000005_create_oauth_personal_access_clients_table', 4),
(12, '2020_10_07_202817_create_password_resets_table', 5);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `client_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `secret` varchar(100) NOT NULL,
  `redirect` text NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `client_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) NOT NULL,
  `access_token_id` varchar(100) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `terms_of_user` text DEFAULT NULL,
  `privacy_policy` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `terms_of_user`, `privacy_policy`) VALUES
(1, '<p style=\"margin-left:48px; margin-right:89px\"><em><strong>What are cookies 🍪? </strong></em></p>\r\n\r\n<p style=\"margin-left:48px\">Cookies are small files that are stored on the computer of a website visitor. These files store small amounts of data for a specific user and website, which can be accessed from the user&#39;s computer. The web page can therefore be tailored to the user. The SOCRAI website only uses essential cookies.</p>\r\n\r\n<p style=\"margin-left:48px\"><strong>Cookies on our website </strong></p>\r\n\r\n<ol>\r\n	<li><em>This website may use cookies. By using this website and agreeing to this policy, you consent to our use of cookies in accordance with the terms of this policy. On a practical level, the user will see a pop-up banner indicating the use of cookies. That banner contains a link to this Cookies policy. The user will be asked to accept the use of cookies by ticking the box provided for this purpose in the banner. If the user clicks through to other places on the SOCRAI website without ticking this box, this will be regarded as explicit consent to the use of cookies. </em></li>\r\n	<li><em>Of course, it is possible - usually through your browser settings - to choose to be notified each time your computer system uses cookies. You can also disable the use of cookies on your browser. Since each browser is different, please check your browser&#39;s help section. Since SOCRAI only uses essential cookies, the SOCRAI Platform and website will no longer function properly if cookies are disabled.</em></li>\r\n</ol>\r\n\r\n<p style=\"margin-left:48px\">SOCRAI may use the following cookies on this website, for the following purposes:</p>\r\n\r\n<ol start=\"3\">\r\n	<li><strong>Targeting cookies&nbsp;🍪</strong></li>\r\n</ol>\r\n\r\n<p style=\"margin-left:47px\">We use essential cookies only to understand your preferences based on previous or current activities on the SOCRAI website or platform. Thanks to this information, we can offer you a better service. We also use cookies to interpret traffic data on our website and the SOCRAI Platform, as well as to assess their interaction. These insights provide a better user experience and form the basis for the development of new tools. To collect this information, we use the services of third parties, who act on our behalf.</p>\r\n\r\n<p style=\"margin-left:47px\">&nbsp;</p>\r\n\r\n<ol start=\"4\">\r\n	<li>SOCRAI does not retain cookies longer than necessary. We only use essential, permanent cookies: Permanent cookies are used so that the platform recognizes you on subsequent visits. The use of essential cookies is necessary for the website to work; they cannot be disabled or adjusted.</li>\r\n</ol>\r\n\r\n<p style=\"margin-left:48px\"><strong>5.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Contact</strong></p>\r\n\r\n<p>privacy@SOCRAI.com</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p style=\"margin-left:48px; margin-right:89px\">&nbsp;</p>\r\n\r\n<table style=\"width:100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<p style=\"margin-left:48px; margin-right:89px\">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ===== End of the cookies policy =====</p>\r\n\r\n			<p>&nbsp;</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </strong></p>\r\n\r\n<p>&nbsp;</p>', '<p>...Thanks for visiting SOCRAI website, Platform and/or Mobile application. This policy explains the what, how, when and why of the information we collect when you visit or use one of our website, platform and/or mobile application. It also explains the specific ways we use and disclose that information. We take your privacy with extreme seriousness, and we don&rsquo;t intend to sell lists or email addresses.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>THE BASICS</strong></p>\r\n\r\n<p><strong>1. Definitions</strong></p>\r\n\r\n<p style=\"margin-left:48px\">These definitions should help you understand this policy. We provide online platforms that you may use to market to or stay in contact with others, including creating, sending, and managing electronic communication and other information related to your Subscribers.</p>\r\n\r\n<p style=\"margin-left:48px\">&nbsp;</p>\r\n\r\n<table align=\"center\" cellspacing=\"0\" class=\"MsoTable15Grid4Accent1\" style=\"border-collapse:collapse; border:none\">\r\n	<tbody>\r\n		<tr>\r\n			<td style=\"background-color:#4472c4; border-bottom:1px solid #4472c4; border-left:1px solid #4472c4; border-right:none; border-top:1px solid #4472c4; height:23px; vertical-align:top; width:211px\">\r\n			<p><strong>Terms </strong></p>\r\n			</td>\r\n			<td style=\"background-color:#4472c4; border-bottom:1px solid #4472c4; border-left:none; border-right:1px solid #4472c4; border-top:1px solid #4472c4; height:23px; vertical-align:top; width:703px\">\r\n			<p>&nbsp;</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"background-color:#d9e2f3; border-bottom:1px solid #8eaadb; border-left:1px solid #8eaadb; border-right:1px solid #8eaadb; border-top:none; height:23px; vertical-align:top; width:211px\">\r\n			<p><strong>SOCRAI website, platform and/or mobile application</strong></p>\r\n			</td>\r\n			<td style=\"background-color:#d9e2f3; border-bottom:1px solid #8eaadb; border-left:none; border-right:1px solid #8eaadb; border-top:none; height:23px; vertical-align:top; width:703px\">\r\n			<p>SOCRAI website, Platform and/or Mobile application</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"border-bottom:1px solid #8eaadb; border-left:1px solid #8eaadb; border-right:1px solid #8eaadb; border-top:none; height:23px; vertical-align:top; width:211px\">\r\n			<p><strong>&ldquo;Tribe member&rdquo;</strong></p>\r\n			</td>\r\n			<td style=\"border-bottom:1px solid #8eaadb; border-left:none; border-right:1px solid #8eaadb; border-top:none; height:23px; vertical-align:top; width:703px\">\r\n			<p>we are referring to the person or entity that is registered with us to use the SOCRAI website, platform and/or mobile application</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"background-color:#d9e2f3; border-bottom:1px solid #8eaadb; border-left:1px solid #8eaadb; border-right:1px solid #8eaadb; border-top:none; height:23px; vertical-align:top; width:211px\">\r\n			<p><strong>&ldquo;we,&rdquo; &ldquo;us,&rdquo; &ldquo;our,&rdquo; and &ldquo;SOCRAI,&rdquo;</strong></p>\r\n			</td>\r\n			<td style=\"background-color:#d9e2f3; border-bottom:1px solid #8eaadb; border-left:none; border-right:1px solid #8eaadb; border-top:none; height:23px; vertical-align:top; width:703px\">\r\n			<p>we are referring to SOCRAI company registered in Belgium</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"border-bottom:1px solid #8eaadb; border-left:1px solid #8eaadb; border-right:1px solid #8eaadb; border-top:none; height:23px; vertical-align:top; width:211px\">\r\n			<p><strong>&ldquo;you&rdquo;</strong></p>\r\n			</td>\r\n			<td style=\"border-bottom:1px solid #8eaadb; border-left:none; border-right:1px solid #8eaadb; border-top:none; height:23px; vertical-align:top; width:703px\">\r\n			<p>we are referring either to a Tribe Member or to some other person who visits any of our Website, platform and/or mobile application. A &ldquo;Subscriber&rdquo; is a person you contact through our website, platform and/or mobile application, or a person who you might choose to contact at some point in the future through the use of our website, platform and/or mobile application.</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"background-color:#d9e2f3; border-bottom:1px solid #8eaadb; border-left:1px solid #8eaadb; border-right:1px solid #8eaadb; border-top:none; height:23px; vertical-align:top; width:211px\">\r\n			<p><strong>A &ldquo;Subscriber&rdquo;</strong></p>\r\n			</td>\r\n			<td style=\"background-color:#d9e2f3; border-bottom:1px solid #8eaadb; border-left:none; border-right:1px solid #8eaadb; border-top:none; height:23px; vertical-align:top; width:703px\">\r\n			<p>is anyone on your Distribution List or about whom you have given us information</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"border-bottom:1px solid #8eaadb; border-left:1px solid #8eaadb; border-right:1px solid #8eaadb; border-top:none; height:23px; vertical-align:top; width:211px\">\r\n			<p><strong>&ldquo;Personal Information&rdquo;</strong></p>\r\n			</td>\r\n			<td style=\"border-bottom:1px solid #8eaadb; border-left:none; border-right:1px solid #8eaadb; border-top:none; height:23px; vertical-align:top; width:703px\">\r\n			<p>means information that can be used to identify you or a Subscriber, including, but not limited to, first and last name, date of birth, email address, gender, occupation or other demographic information.</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"background-color:#d9e2f3; border-bottom:1px solid #8eaadb; border-left:1px solid #8eaadb; border-right:1px solid #8eaadb; border-top:none; height:23px; vertical-align:top; width:211px\">\r\n			<p><strong>A &ldquo;Distribution List&rdquo;</strong></p>\r\n			</td>\r\n			<td style=\"background-color:#d9e2f3; border-bottom:1px solid #8eaadb; border-left:none; border-right:1px solid #8eaadb; border-top:none; height:23px; vertical-align:top; width:703px\">\r\n			<p>&nbsp;is a list of Subscribers and all associated information related to those Subscribers (for example, email addresses)</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p style=\"margin-left:48px\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:48px\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:48px\">This Privacy Policy applies to the SOCRAI website, platform and/or mobile applications, as well as any other sites or mobile applications owned or operated by us (each a &ldquo;Website, platform and/or mobile application&rdquo; and together the &ldquo;SOCRAI services&rdquo;). The &ldquo;SOCRAI services&rdquo; include the Website, platform and/or mobile applications themselves, and any web pages, interactive features, widgets, blogs, social networks, social network &ldquo;tabs,&rdquo; or other online, mobile, or wireless offerings that post a link to this Privacy Policy, whether accessed via computer, mobile device, or other technology, manner or means. While providing the SOCRAI services, and as described in more detail below, we may collect Personal Information about a Website, platform and/or mobile application visitor, Member, person or email address related to a Distribution List, or Subscriber. By using the SOCRAI Service, you agree to the collection and use of personal information and other information in accordance with this policy.</p>\r\n\r\n<p style=\"margin-left:48px\">&nbsp;</p>\r\n\r\n<p><strong>2. Changes</strong></p>\r\n\r\n<p style=\"margin-left:48px\">We may change this Privacy Policy at any time and from time to time. The most recent version of the Privacy Policy is reflected by the version date located above of this Privacy Policy. All updates and amendments are effective immediately upon notice, which we may give by any means, including, but not limited to, by posting a revised version of this Privacy Policy or other notice on the Website, platform and/or mobile application. We encourage you to review this Privacy Policy often to stay informed of changes that may affect you, as your continued use of the Website, platform and/or mobile application signifies your continuing consent to be bound by this Privacy Policy. Our electronically or otherwise properly stored copies of this Privacy Policy are each deemed to be the true, complete, valid, authentic, and enforceable copy of the version of this Privacy Policy which were in effect on each respective date you visited the Website, platform and/or mobile application.</p>\r\n\r\n<p><strong>3. Scope</strong></p>\r\n\r\n<p style=\"margin-left:48px\">This Privacy Policy is effective with respect to any data that we have collected, or collect, about and/or from you.</p>\r\n\r\n<p style=\"margin-left:48px\">&nbsp;</p>\r\n\r\n<p><strong>YOUR INFORMATION</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>4. Information We Collect</strong></p>\r\n\r\n<p style=\"margin-left:48px\">(a) <strong>Information you voluntarily provide to us:</strong>&nbsp;When you sign up for and use the SOCRAI website, Platform and/or Mobile application, consult with our customer service team, send us an email, post on our blog, integrate the SOCRAI website, Platform and/or Mobile application with another website, or communicate with us in any way, you are voluntarily giving us information that we collect. That information may include either your Subscribers&rsquo; name, physical address, email address, IP address, phone number, as well as details including gender, occupation, location, purchase history, and other demographic information. By giving us this information, you consent to this information being collected, used, disclosed, transferred and stored by us, as described in this Privacy Policy.</p>\r\n\r\n<p style=\"margin-left:48px\">(b) <strong>Information we collect automatically:</strong> When you use SOCRAI website, Platform and/or Mobile application or browse on one of our services, we may collect information about your visit to our Website, platform and/or mobile applications, your usage of our services, and your web browsing. That information may include your IP address, your operating system, your browser ID, your browsing activity, and other information about how you interacted with our Website, platform and/or mobile applications. We may collect this information as a part of log files as well as through the use of cookies or other tracking technologies.</p>\r\n\r\n<p style=\"margin-left:48px\">(c) <strong>Information from the use of our Website, Platform and/or Mobile Application:</strong> When you use our Website, Platform and/or Mobile Application, we may collect certain information in addition to information described elsewhere in this Policy. For example, we may collect information about the type of device and operating system you use. We may ask you if you want to receive push notifications about activity in your account. If you have opted in to these notifications and no longer want to receive them, you may turn them off through your operating system. We do not ask for, access or track any location-based information from your mobile device at any time while downloading or using our services or Mobile apps. We may use mobile analytics software to better understand how people use our mobile apps. We may collect information about how often you use the Website, Platform and/or Mobile Application and other performance data.</p>\r\n\r\n<p style=\"margin-left:48px\">&nbsp;</p>\r\n\r\n<p><strong>5. Use and Disclosure of Personal Information</strong></p>\r\n\r\n<p style=\"margin-left:48px\">We may use and disclose Personal Information only for the following purposes:</p>\r\n\r\n<p style=\"margin-left:48px\">(a) <strong>To promote use of our Website, Platform and/or Mobile Application to you and others.</strong>&nbsp;For example, if you leave your Personal Information when you visit our Website, platform and/or mobile application and do not sign up for any of the SOCRAI services, we may send you an email inviting you to sign up. If you use any of our services and we think you might benefit from using another Service we offer, we may send you an email about that. You can stop receiving our promotional emails by following the unsubscribe instructions included in every email we send. In addition, we may use information we collect in order to advertise our Website, Platform and/or Mobile Application to you or suggest additional features of our SOCRAI services that you might consider using. In addition, we may use your Personal Information to advertise our Website, Platform and/or Mobile Application to potential or other users like you.</p>\r\n\r\n<p style=\"margin-left:48px\">(b) <strong>To send you informational and promotional content that you may choose (or &ldquo;opt in&rdquo;) to receive.</strong>&nbsp;You can stop receiving our promotional emails by following the unsubscribe instructions included in every email.</p>\r\n\r\n<p style=\"margin-left:48px\">(c) <strong>To send you System Alert messages.</strong>&nbsp;For example, we may inform you of temporary or permanent changes to our Website, Platform and/or Mobile Application, such as planned outages, new features, version updates, releases, abuse warnings, and changes to our Privacy Policy.</p>\r\n\r\n<p style=\"margin-left:48px\">(d) <strong>To communicate with our Tribe members about their account and provide customer support.</strong></p>\r\n\r\n<p style=\"margin-left:48px\">(e) <strong>To protect the rights and safety of our Tribe members and third parties, as well as our own.</strong></p>\r\n\r\n<p style=\"margin-left:48px\">(f) <strong>To meet legal requirements,</strong>&nbsp;including complying with court orders, valid discovery requests, valid subpoenas, and other appropriate legal mechanisms.</p>\r\n\r\n<p style=\"margin-left:48px\">(g) <strong>To prosecute and defend a court, arbitration, or similar legal proceeding.</strong></p>\r\n\r\n<p style=\"margin-left:48px\">(h) <strong>To respond to lawful requests by public authorities, including to meet national security or law enforcement requirements.</strong></p>\r\n\r\n<p style=\"margin-left:48px\">(l) <strong>To provide, support, and improve the Website, Platform and/or Mobile Application we offer.</strong>&nbsp;This includes our use of the data that our Tribe members provide us in order to enable our Tribe members to use Website, Platform and/or Mobile Application to communicate with their Subscribers. This also includes, for example, aggregating information from your use of the Website, Platform and/or Mobile Application or visit to our SOCRAI services and sharing this information with third parties to improve our services. This might also include sharing your information or the information you provide us about your Subscribers with third parties in order to provide and support our Website, Platform and/or Mobile Application or to make certain features of the SOCRAI serveces available to you. When we do have to share Personal Information with third parties, we take steps to protect your information by requiring these third parties to enter into a contract with us that requires them to use the Personal Information we transfer to them in a manner that is consistent with this policy.</p>\r\n\r\n<p style=\"margin-left:48px\">(j) <strong>To provide suggestions to you.</strong>&nbsp;This includes adding features that compare Tribe members&rsquo; email campaigns, using data to suggest other publishers your Subscribers may be interested in, or using data to suggest products or services that you may be interested in or that may be relevant to you or your Subscribers.</p>\r\n\r\n<p style=\"margin-left:48px\">&nbsp;</p>\r\n\r\n<p><strong>6. Data Collected for and by our Users</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<ol style=\"list-style-type:lower-alpha\">\r\n	<li><strong>Companies </strong></li>\r\n</ol>\r\n\r\n<p style=\"margin-left:48px\">As you use our Website, Platform and/or Mobile Application, you may import into our system Personal Information you have collected from your Subscribers or other individuals. We have no direct relationship with your Subscribers or any person other than you, and for that reason, you are responsible for making sure you have the appropriate permission for us to collect and process information about those individuals. Consistent with the uses of Personal Information covered in Section 5, we may transfer Personal Information of you or your Subscribers to companies that help us promote, provide, or support our Website, Platform and/or Mobile Application or the services of our partners (&ldquo;Service Providers&rdquo;). All Service Providers enter into a contract with us that protects Personal Information and restricts their use of any Personal Information consistent with this policy. As part of our Services, we may use and incorporate into features information you have provided, we have collected from you, or we have collected about Subscribers. We may share this information, including Subscriber email addresses, with third parties in line with the approved uses in Section 5.</p>\r\n\r\n<ol start=\"2\" style=\"list-style-type:lower-alpha\">\r\n	<li><strong>Individuals </strong></li>\r\n</ol>\r\n\r\n<p style=\"margin-left:48px\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:48px\">As you use our Website, Platform and/or Mobile Application, you may freely import into our system your Personal Information. By using the SOCRAI Services, you accept the use of your Personal Information in accordance with Section 5 and this Privacy Policy.&nbsp;</p>\r\n\r\n<p style=\"margin-left:48px\">&nbsp;</p>\r\n\r\n<ol start=\"3\" style=\"list-style-type:lower-alpha\">\r\n	<li><strong>Transfer of Personal Information </strong></li>\r\n</ol>\r\n\r\n<p style=\"margin-left:48px\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:48px\">Consistent with the uses of Personal Information covered in Section 5, we may transfer Personal Information of you as an &ldquo;individual&rdquo; or your Subscribers to companies that help us promote,&nbsp; provide, or support our Website, Platform and/or Mobile Application or the services of our partners (&ldquo;Service Providers&rdquo;). All Service Providers enter into a contract with us that protects Personal Information and restricts their use of any Personal Information consistent with this policy. As part of our Services, we may use and incorporate into features information you have provided, we have collected from you, or we have collected about Subscribers. We may share this information, including Subscriber email addresses, with third parties in line with the approved uses in Section 5.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p style=\"margin-left:48px\">We will retain Personal Information we process on behalf of our Tribe members for as long as needed to provide our Services or to comply with our legal obligations, resolve disputes, prevent abuse, and enforce our agreements.</p>\r\n\r\n<p style=\"margin-left:48px\">&nbsp;</p>\r\n\r\n<p><strong>7. Public Information and Third-Party Websites</strong></p>\r\n\r\n<p style=\"margin-left:48px\">(a) Blog. We have public blogs on our Website, platform and/or mobile applications. Any information you include in a comment on our blog may be read, collected, and used by anyone.</p>\r\n\r\n<p style=\"margin-left:48px\">(b) Social media platforms and widgets. Our Website, platform and/or mobile applications include social media features, such as the Facebook Like button. These features may collect information about your IP address and which page you are visiting on our Website, platform and/or mobile application, and they may set a cookie to make sure the feature functions properly. Social media features and widgets are either hosted by a third party or hosted directly on our Website, platform and/or mobile application. We also maintain presences on all our social media platforms. Any information, communications, or materials you submit to us via a social media platform is done at your own risk without any expectation of privacy. We cannot control the actions of other users of these platforms or the actions of the platforms themselves. Your interactions with those features and platforms are governed by the privacy policies of the companies that provide them.</p>\r\n\r\n<p style=\"margin-left:48px\">(c) Links to third-party websites. Our Website, platform and/or mobile applications include links to other websites, whose privacy practices may be different from SOCRAI. If you submit Personal Information to any of those sites, your information is governed by their privacy policies. We encourage you to carefully read the privacy policy of any Website you visit.</p>\r\n\r\n<p style=\"margin-left:48px\">&nbsp;</p>\r\n\r\n<p><strong>8. Third Parties</strong></p>\r\n\r\n<p style=\"margin-left:48px\">We may disclose Personal Information to the following types of third parties for the purposes described in this policy:</p>\r\n\r\n<p style=\"margin-left:48px\">Service providers. Sometimes, we need to use third party Service Providers in order to provide and support the features of our Website, Platform and/or Mobile application. Then we may share your Personal Information with a Service Provider for that purpose. We will tell you we are working with a Service Provider whenever reasonably possible, and you may request at any time the names of our Service Providers. Just like with the other third parties we work with, these third-party Service Providers enter into a contract that requires them to use your Personal Information in a manner that is consistent with this policy.</p>\r\n\r\n<p style=\"margin-left:48px\">&nbsp;</p>\r\n\r\n<p><strong>SECURITY</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>9. Notice of Breach of Security</strong></p>\r\n\r\n<p style=\"margin-left:48px\">If a security breach causes an unauthorized intrusion into our system that materially affects you or people on your Distribution Lists, then SOCRAI will notify you as soon as possible and later report the action we took in response.</p>\r\n\r\n<p><strong>10. Safeguarding Your Information</strong></p>\r\n\r\n<p style=\"margin-left:48px\">We take reasonable and appropriate measures to protect Personal Information from loss, misuse and unauthorized access, disclosure, alteration and destruction, taking into account the risks involved in the processing and the nature of the Personal Information.</p>\r\n\r\n<p style=\"margin-left:48px\">If you have any questions about the security of your Personal Information, you may contact us at&nbsp;privacy@SOCRAI.com.</p>\r\n\r\n<p style=\"margin-left:48px\">SOCRAI accounts require a username and password to log in. You must keep your username and password secure, and never disclose it to a third party. Account passwords are encrypted, which means we cannot see your passwords. We cannot resend forgotten passwords either. We will only reset them. For the use of our services, please refer to our Website terms for End-users.</p>\r\n\r\n<p style=\"margin-left:48px\">&nbsp;</p>\r\n\r\n<p><strong>COMPLIANCE</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>11. We Operate in Europe</strong></p>\r\n\r\n<p style=\"margin-left:48px\">Our servers and offices are located in Europe, so your information may be transferred to, stored, or processed in Europe. we take many steps to protect your privacy. By using our Website, platform and/or mobile application, you understand and consent to the collection, storage, processing, and transfer of your information to our facilities in Europe and those third parties with whom we share it as described in this policy.</p>\r\n\r\n<p><strong>12. Accuracy of Data, Transparency, and Choice</strong></p>\r\n\r\n<p style=\"margin-left:48px\">We do our best to keep your data accurate and up to date, to the extent that you provide us with the information we need to do so. If your data changes (for example, if you have a new email address), then you are responsible for notifying us of those changes. Upon request, we will provide you with information about whether we hold, or process on behalf of a third party, any of your Personal Information.</p>\r\n\r\n<p style=\"margin-left:48px\">We will retain your information for as long as your account is active or as long as needed to provide you with our Services. We may also retain and use your information in order to comply with our legal obligations, resolve disputes, prevent abuse, and enforce our Agreements.</p>\r\n\r\n<p style=\"margin-left:48px\">As explained in Section 8 of this policy, SOCRAI shares your Personal Information and the Personal with Service Providers in order to provide and support our Services.</p>\r\n\r\n<p><strong>13. Access</strong></p>\r\n\r\n<p style=\"margin-left:48px\">We will give an individual, either you or a Subscriber, access to any Personal Information we hold about them within 30 days of any request for that information. Individuals may request to access, correct, amend or delete information we hold about them. Unless it is prohibited by law, we will remove any Personal Information about an individual, either you or a Subscriber, from our servers at your or their request. There is no charge for an individual to access or update their Personal Information.</p>\r\n\r\n<p style=\"margin-left:48px\">&nbsp;</p>\r\n\r\n<p><strong>14. Questions &amp; Concerns</strong></p>\r\n\r\n<p>If you have any questions or comments, or if you want to update, delete, or change any Personal Information we hold, or you have a concern about the way in which we have handled any privacy matter, please contact us by postal mail or email at:</p>\r\n\r\n<table style=\"width:100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<p style=\"margin-left:48px\">SOCRAI<br />\r\n			Attn. Privacy Officer<br />\r\n			privacy@SOCRAI.com<br />\r\n			Zone 1 Research Park 310<br />\r\n			1731 ASSE, Belgium</p>\r\n\r\n			<p style=\"margin-left:48px\">&nbsp;</p>\r\n\r\n			<p>&nbsp;</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p style=\"margin-left:48px\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:48px\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:48px; margin-right:89px\"><em><strong>Updated July 05th,&nbsp; 2021&nbsp;&ndash; Legal</strong></em></p>\r\n\r\n<p style=\"margin-left:48px; margin-right:89px\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:48px; margin-right:89px\">&nbsp;</p>\r\n\r\n<p style=\"margin-left:48px; margin-right:89px\"><em>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ===== End of the privacy policy =====</em></p>\r\n\r\n<p style=\"margin-left:48px; margin-right:89px\">&nbsp;</p>\r\n\r\n<p>&nbsp;</p>');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `question_answers`
--

CREATE TABLE `question_answers` (
  `id` int(10) UNSIGNED NOT NULL,
  `question` varchar(5000) NOT NULL,
  `answer` varchar(10000) DEFAULT NULL,
  `clue` varchar(50) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT 0,
  `status` varchar(10) DEFAULT 'locked',
  `media` varchar(255) DEFAULT '0',
  `media_type` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `question_exercise`
--

CREATE TABLE `question_exercise` (
  `id` int(11) NOT NULL,
  `question_answer_id` int(11) NOT NULL,
  `exercise_question_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `emial_reset_pass` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `emial_reset_pass`) VALUES
(1, 'sisapps@stepinnsolution.com');

-- --------------------------------------------------------

--
-- Table structure for table `temp_import_questions`
--

CREATE TABLE `temp_import_questions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `answer` varchar(255) NOT NULL,
  `clue` varchar(50) NOT NULL,
  `level` int(11) NOT NULL,
  `media` int(11) NOT NULL,
  `media_type` varchar(255) NOT NULL,
  `question_type` varchar(10) NOT NULL,
  `linked` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE `topics` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` text NOT NULL,
  `tribe_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `question_points` int(11) DEFAULT 1,
  `exercise_points` int(11) DEFAULT NULL,
  `exercise_points_correct` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tribes`
--

CREATE TABLE `tribes` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` text NOT NULL,
  `leader` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `unlocked_exercises`
--

CREATE TABLE `unlocked_exercises` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `exercise_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `image` text NOT NULL,
  `name` text NOT NULL,
  `created_by_admin` varchar(100) NOT NULL DEFAULT '0',
  `email` text NOT NULL,
  `password` text NOT NULL,
  `user_role` int(11) NOT NULL DEFAULT 0 COMMENT 'Admin  - 1\r\nSucria Leader   - 2\r\nTribe Leader - 3',
  `is_leader` tinyint(4) NOT NULL DEFAULT 0,
  `is_email_varified` tinyint(4) NOT NULL DEFAULT 0,
  `varif_code` varchar(10) NOT NULL DEFAULT '0',
  `country` text DEFAULT NULL,
  `state` text DEFAULT NULL,
  `city` text DEFAULT NULL,
  `level` int(11) NOT NULL DEFAULT 0,
  `remember_token` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tfa` tinyint(4) NOT NULL DEFAULT 0,
  `two_factor_code` text DEFAULT NULL,
  `two_factor_expires_at` datetime DEFAULT NULL,
  `is_blocked` varchar(3) DEFAULT 'No',
  `rememberme` varchar(3) DEFAULT NULL,
  `login_attempts` tinyint(4) NOT NULL DEFAULT 0,
  `rememberme_browser_name` varchar(100) DEFAULT NULL,
  `rememberme_browser_type` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `image`, `name`, `created_by_admin`, `email`, `password`, `user_role`, `is_leader`, `is_email_varified`, `varif_code`, `country`, `state`, `city`, `level`, `remember_token`, `created_at`, `updated_at`, `tfa`, `two_factor_code`, `two_factor_expires_at`, `is_blocked`, `rememberme`, `login_attempts`, `rememberme_browser_name`, `rememberme_browser_type`) VALUES
(1, '', 'Site Admin', '0', 'siteadmin@socrai.com', '$2y$10$Q7tcFeLew6eFgJXS2unRZu6KPmiU5u3yPI9pMjUAp.d4B2yXZseRK', 1, 0, 0, '0', NULL, NULL, NULL, 0, '', NULL, NULL, 0, '333027', NULL, 'No', NULL, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_questions`
--

CREATE TABLE `user_questions` (
  `id` int(10) UNSIGNED NOT NULL,
  `question_answer_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `earned_points` int(11) NOT NULL DEFAULT 0,
  `exercise_unlocked` varchar(255) NOT NULL DEFAULT 'no',
  `exercise_question_true` varchar(10) NOT NULL DEFAULT 'no',
  `level_crossed` varchar(255) NOT NULL DEFAULT 'no',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_tribes`
--

CREATE TABLE `user_tribes` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `tribe_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attempts`
--
ALTER TABLE `attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comment_likes`
--
ALTER TABLE `comment_likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `discussions`
--
ALTER TABLE `discussions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `join_requests`
--
ALTER TABLE `join_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_securities`
--
ALTER TABLE `login_securities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `media_types`
--
ALTER TABLE `media_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_personal_access_clients_client_id_index` (`client_id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `password_resets_email_index` (`email`(250));

--
-- Indexes for table `question_answers`
--
ALTER TABLE `question_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `question_exercise`
--
ALTER TABLE `question_exercise`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `temp_import_questions`
--
ALTER TABLE `temp_import_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tribes`
--
ALTER TABLE `tribes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `unlocked_exercises`
--
ALTER TABLE `unlocked_exercises`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_questions`
--
ALTER TABLE `user_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_tribes`
--
ALTER TABLE `user_tribes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attempts`
--
ALTER TABLE `attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comment_likes`
--
ALTER TABLE `comment_likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `discussions`
--
ALTER TABLE `discussions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `join_requests`
--
ALTER TABLE `join_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login_securities`
--
ALTER TABLE `login_securities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `media_types`
--
ALTER TABLE `media_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `question_answers`
--
ALTER TABLE `question_answers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `question_exercise`
--
ALTER TABLE `question_exercise`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `temp_import_questions`
--
ALTER TABLE `temp_import_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tribes`
--
ALTER TABLE `tribes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `unlocked_exercises`
--
ALTER TABLE `unlocked_exercises`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_questions`
--
ALTER TABLE `user_questions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_tribes`
--
ALTER TABLE `user_tribes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
