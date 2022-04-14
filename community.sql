/*
Navicat MySQL Data Transfer

Source Server         : 120.26.71.236_3306
Source Server Version : 50729
Source Host           : 120.26.71.236:3306
Source Database       : community

Target Server Type    : MYSQL
Target Server Version : 50729
File Encoding         : 65001

Date: 2020-04-03 00:08:04
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for cm_admin_action
-- ----------------------------
DROP TABLE IF EXISTS `cm_admin_action`;
CREATE TABLE `cm_admin_action` (
  `action_id` tinyint(3) NOT NULL AUTO_INCREMENT,
  `parent_id` tinyint(3) NOT NULL DEFAULT '0' COMMENT '对应action_id方法名对应的类名id',
  `action_code` varchar(50) NOT NULL DEFAULT '0' COMMENT 'parent_id为0是类名其他方法名',
  `action_name` varchar(20) NOT NULL COMMENT 'action名字',
  PRIMARY KEY (`action_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='访问权限列表';

-- ----------------------------
-- Records of cm_admin_action
-- ----------------------------
INSERT INTO `cm_admin_action` VALUES ('1', '0', '0', '系统用户');
INSERT INTO `cm_admin_action` VALUES ('2', '1', 'AdminUser/user', '管理员');
INSERT INTO `cm_admin_action` VALUES ('3', '1', 'AdminRole/role', '角色管理');
INSERT INTO `cm_admin_action` VALUES ('4', '0', '0', '协议管理');
INSERT INTO `cm_admin_action` VALUES ('5', '4', 'Set/setUserAgree', '用户协议');
INSERT INTO `cm_admin_action` VALUES ('6', '0', '0', '设置');
INSERT INTO `cm_admin_action` VALUES ('7', '6', 'Set/setPassword', '修改密码');
INSERT INTO `cm_admin_action` VALUES ('8', '0', '0', '用户');
INSERT INTO `cm_admin_action` VALUES ('9', '8', 'User/user', '用户列表');
INSERT INTO `cm_admin_action` VALUES ('10', '8', 'Question/question', '用户问题');
INSERT INTO `cm_admin_action` VALUES ('11', '0', '0', '标签');
INSERT INTO `cm_admin_action` VALUES ('12', '11', 'Tag/tag', '标签');
INSERT INTO `cm_admin_action` VALUES ('13', '8', 'Comment/comment', '用户评论');

-- ----------------------------
-- Table structure for cm_admin_role
-- ----------------------------
DROP TABLE IF EXISTS `cm_admin_role`;
CREATE TABLE `cm_admin_role` (
  `role_id` tinyint(3) NOT NULL AUTO_INCREMENT,
  `role_name` char(20) DEFAULT NULL,
  `role_visit_list` text COMMENT '角色可访问的方法列表',
  `role_descr` varchar(100) DEFAULT NULL COMMENT '角色说明',
  PRIMARY KEY (`role_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='角色表';

-- ----------------------------
-- Records of cm_admin_role
-- ----------------------------
INSERT INTO `cm_admin_role` VALUES ('1', 'admin', '2,3,5,7,9,10,12,13', '超级管理员');

-- ----------------------------
-- Table structure for cm_admin_user
-- ----------------------------
DROP TABLE IF EXISTS `cm_admin_user`;
CREATE TABLE `cm_admin_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `user_account` varchar(255) NOT NULL DEFAULT '' COMMENT '账户',
  `user_password` varchar(255) NOT NULL DEFAULT '' COMMENT '密码',
  `user_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '用户状态 1正常 2禁用',
  `role_id` int(11) NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of cm_admin_user
-- ----------------------------
INSERT INTO `cm_admin_user` VALUES ('1', 'root', '63a9f0ea7bb98050796b649e85481845', '1', '1', '2020-03-22 23:17:08', '2020-03-22 23:17:08');

-- ----------------------------
-- Table structure for cm_comment
-- ----------------------------
DROP TABLE IF EXISTS `cm_comment`;
CREATE TABLE `cm_comment` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '评论id',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '上级id',
  `question_id` int(11) NOT NULL COMMENT '问题id',
  `reply_id` int(11) NOT NULL COMMENT '评论id 一级为0',
  `user_id` int(11) NOT NULL COMMENT '被评论人的id',
  `comment_content` varchar(255) NOT NULL COMMENT '评论内容',
  `like_num` int(11) NOT NULL DEFAULT '0' COMMENT '点赞数',
  `is_read` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否已读 0未读 1已读',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`comment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of cm_comment
-- ----------------------------

-- ----------------------------
-- Table structure for cm_question
-- ----------------------------
DROP TABLE IF EXISTS `cm_question`;
CREATE TABLE `cm_question` (
  `question_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `question_title` varchar(255) NOT NULL COMMENT '标题',
  `question_description` text NOT NULL COMMENT '描述',
  `tag` varchar(255) NOT NULL COMMENT '标签',
  `read_num` int(11) NOT NULL DEFAULT '0' COMMENT '浏览数',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`question_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of cm_question
-- ----------------------------

-- ----------------------------
-- Table structure for cm_set
-- ----------------------------
DROP TABLE IF EXISTS `cm_set`;
CREATE TABLE `cm_set` (
  `set_id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `set_user_agree` text COMMENT '协议的内容',
  PRIMARY KEY (`set_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COMMENT='设置表';

-- ----------------------------
-- Records of cm_set
-- ----------------------------
INSERT INTO `cm_set` VALUES ('1', '<p>一、总则</p><p><span>			</span> 1.1　用户应当同意本协议的条款并按照页面上的提示完成全部的注册程序。用户在进行注册程序过程中勾选\"我已阅读并接受\"模块即表示用户与产品名称达成协议，完全接受本协议项下的全部条款。</p><p><br></p><p><span>			</span> 1.2　用户注册成功后，产品名称将给予每个用户一个用户帐号及相应的密码，该用户帐号和密码由用户负责保管；用户应当对以其用户帐号进行的所有活动和事件负法律责任。</p><p><br></p><p><span>			</span> 1.3　用户可以使用产品名称各个频道单项服务，当用户使用产品名称各单项服务时，用户的使用行为视为其对该单项服务的服务条款以及产品名称在该单项服务中发出的各类公告的同意。</p><p><br></p><p><span>			</span> 二、注册信息和隐私保护</p><p><span>			</span> 2.1　产品名称帐号（即产品名称用户ID）的所有权归产品名称，用户完成注册申请后，获得产品名称帐号的使用权。所有原始键入的资料将引用为注册资料。如果因注册信息不真实而引起的问题，并对问题发生所带来的后果，产品名称不负任何责任。</p><p><br></p><p><span>			</span> 2.2　用户不应将其帐号、密码转让或出借予他人使用。如用户发现其帐号遭他人非法使用，应立即通知产品名称。因黑客行为或用户的保管疏忽导致帐号、密码遭他人非法使用，产品名称不承担任何责任。</p><p><br></p><p><span>			</span> 2.3　产品名称不对外公开或向第三方提供单个用户的注册资料，除非：</p><p><span>			</span>• 事先获得用户的明确授权；</p><p><span>			</span>• 只有透露您的个人资料，才能提供您所要求的产品和服务；</p><p><span>			</span>• 根据有关的法律法规要求；</p><p><span>			</span>• 按照相关政府主管部门的要求；</p><p><span>			</span>• 为维护产品名称的合法权益。</p><p><br></p><p><span>			</span> 2.4　在您注册产品名称，使用其他产品名称产品或服务，访问产品名称网页时，产品名称会收集您的个人身份识别资料，并会将这些资料用于：改进为你提供的服务及网页内容。</p><p><br></p><p><span>			</span>三、使用规则</p><p><span>			</span> 3.1　用户在使用产品名称服务时，必须遵守中华人民共和国相关法律法规的规定，用户应同意将不会利用本服务进行任何违法或不正当的活动，包括但不限于下列行为∶</p><p><span>			</span>• 上载、展示、张贴、传播或以其它方式传送含有下列内容之一的信息：</p><p><span>			</span>• 不得为任何非法目的而使用网络服务系统</p><p><span>			</span> 不利用产品名称服务从事以下活动：</p><p><span>			</span>• 未经允许，进入计算机信息网络或者使用计算机信息网络资源的；</p><p><span>			</span>• 未经允许，对计算机信息网络功能进行删除、修改或者增加的；</p><p><span>			</span>• 未经允许，对进入计算机信息网络中存储、处理或者传输的数据和应用程序进行删除、修改或者增加的；</p><p><span>			</span>• 故意制作、传播计算机病毒等破坏性程序的；</p><p><span>			</span>• 其他危害计算机信息网络安全的行为。</p><p><br></p><p><span>			</span> 3.2　用户违反本协议或相关的服务条款的规定，导致或产生的任何第三方主张的任何索赔、要求或损失，包括合理的律师费，您同意赔偿数据堂与合作公司、关联公司，并使之免受损害。对此，产品名称有权视用户的行为性质，采取包括但不限于删除用户发布信息内容、暂停使用许可、终止服务、限制使用、回收产品名称帐号、追究法律责任等措施。对恶意注册产品名称帐号或利用产品名称帐号进行违法活动、捣乱、骚扰、欺骗、其他用户以及其他违反本协议的行为，产品名称有权回收其帐号。同时，产品名称会视司法部门的要求，协助调查。</p><p><br></p><p><span>			</span> 3.3　用户不得对本服务任何部分或本服务之使用或获得，进行复制、拷贝、出售、转售或用于任何其它商业目的。</p><p><br></p><p><span>			</span> 3.4　用户须对自己在使用产品名称服务过程中的行为承担法律责任。用户承担法律责任的形式包括但不限于：对受到侵害者进行赔偿，以及在产品名称首先承担了因用户行为导致的行政处罚或侵权损害赔偿责任后，用户应给予产品名称等额的赔偿。</p><p><br></p><p><span>			</span> 四、服务内容</p><p><br></p><p><span>			</span> 4.1　产品名称网络服务的具体内容由产品名称根据实际情况提供。</p><p><br></p><p><span>			</span> 4.2　除非您与产品名称另有约定，您同意本服务仅为您个人非商业性质的使用。</p><p><br></p><p><span>			</span> 4.3　产品名称的部分服务是以收费方式提供的，如您使用收费服务，请遵守相关的协议。</p><p><br></p><p><span>			</span> 4.4　产品名称可能根据实际需要对收费服务的收费标准、方式进行修改和变更，产品名称也可能会对部分免费服务开始收费。前述修改、变更或开始收费前，产品名称将在相应服务页面进行通知或公告。如果您不同意上述修改、变更或付费内容，则应停止使用该服务。</p><p><br></p><p><span>			</span> 4.5　产品名称网络需要定期或不定期地对提供网络服务的平台或相关的设备进行检修或者维护，如因此类情况而造成网络服务（包括收费网络服务）在合理时间内的中断，产品名称网络无需为此承担任何责任。产品名称网络保留不经事先通知为维修保养、升级或其它目的暂停本服务任何部分的权利。</p><p><br></p><p><span>			</span> 4.6　本服务或第三人可提供与其它国际互联网上之网站或资源之链接。由于产品名称网络无法控制这些网站及资源，您了解并同意，此类网站或资源是否可供利用，产品名称网络不予负责，存在或源于此类网站或资源之任何内容、广告、产品或其它资料，产品名称网络亦不予保证或负责。因使用或依赖任何此类网站或资源发布的或经由此类网站或资源获得的任何内容、商品或服务所产生的任何损害或损失，产品名称网络不承担任何责任。</p><p><br></p><p><span>			</span> 4.7　产品名称网络对在服务网上得到的任何商品购物服务、交易进程、招聘信息，都不作担保。</p><p><br></p><p><span>			</span> 4.8　产品名称网络有权于任何时间暂时或永久修改或终止本服务（或其任何部分），而无论其通知与否，产品名称对用户和任何第三人均无需承担任何责任。</p><p><br></p><p><span>			</span> 4.9　终止服务</p><p><span>			</span> 您同意产品名称得基于其自行之考虑，因任何理由，包含但不限于产品名称认为您已经违反本服务协议的文字及精神，终止您的密码、帐号或本服务之使用（或服务之任何部分），并将您在本服务内任何内容加以移除并删除。您同意依本服务协议任何规定提供之本服务，无需进行事先通知即可中断或终止，您承认并同意，产品名称可立即关闭或删除您的帐号及您帐号中所有相关信息及文件，或禁止继续使用前述文件或本服务。此外，您同意若本服务之使用被中断或终止或您的帐号及相关信息和文件被关闭或删除，产品名称对您或任何第三人均不承担任何责任。</p><p><br></p><p><span>			</span> 五、知识产权和其他合法权益（包括但不限于名誉权、商誉权）</p><p><br></p><p><span>			</span> 5.1　产品名称在本服务中提供的内容（包括但不限于网页、文字、图片、音频、视频、图表等）的知识产权归产品名称所有，用户在使用本服务中所产生的内容的知识产权归用户或相关权利人所有。</p><p><br></p><p><span>			</span> 5.2 除另有特别声明外，产品名称提供本服务时所依托软件的著作权、专利权及其他知识产权均归产品名称所有。</p><p><br></p><p><span>			</span> 5.3 产品名称在本服务中所使用的“产品名称”等商业标识，其著作权或商标权归产品名称所有。</p><p><br></p><p><span>			</span> 5.4 上述及其他任何本服务包含的内容的知识产权均受到法律保护，未经产品名称、用户或相关权利人书面许可，任何人不得以任何形式进行使用或创造相关衍生作品。</p><p><br></p><p><span>			</span> 六、未成年人使用条款</p><p><span>				</span> 6.1 若用户未满18周岁，则为未成年人，应在监护人监护、指导下阅读本协议和使用本服务。</p><p><br></p><p><span>				</span> 6.2</p><p><span>					</span>未成年人用户涉世未深，容易被网络虚象迷惑，且好奇心强，遇事缺乏随机应变的处理能力，很容易被别有用心的人利用而又缺乏自我保护能力。因此，未成年人用户在使用本服务时应注意以下事项，提高安全意识，加强自我保护：</p><p><span>				</span> （1）认清网络世界与现实世界的区别，避免沉迷于网络，影响日常的学习生活；</p><p><span>				</span> （2）填写个人资料时，加强个人保护意识，以免不良分子对个人生活造成骚扰；</p><p><span>				</span> （3）在监护人或老师的指导下，学习正确使用网络；</p><p><span>				</span> （4）避免陌生网友随意会面或参与联谊活动，以免不法分子有机可乘，危及自身安全。</p><p><br></p><p><span>				</span> 七、其他</p><p><br></p><p><span>				</span> 7.1　本协议的订立、执行和解释及争议的解决均应适用中华人民共和国法律。</p><p><br></p><p><span>				</span> 7.2　如双方就本协议内容或其执行发生任何争议，双方应尽量友好协商解决；协商不成时，任何一方均可向产品名称所在地的人民法院提起诉讼。</p><p><br></p><p><span>				</span> 7.3　产品名称未行使或执行本服务协议任何权利或规定，不构成对前述权利或权利之放弃。</p><p><br></p><p><span>				</span> 7.4　如本协议中的任何条款无论因何种原因完全或部分无效或不具有执行力，本协议的其余条款仍应有效并且有约束力。</p><p><br></p><p><span>				</span> 请您在发现任何违反本服务协议以及其他任何单项服务的服务条款、产品名称各类公告之情形时，通知产品名称。</p><p><span>			</span></p>');

-- ----------------------------
-- Table structure for cm_tag
-- ----------------------------
DROP TABLE IF EXISTS `cm_tag`;
CREATE TABLE `cm_tag` (
  `tag_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `tag_name` varchar(255) NOT NULL COMMENT '标签名字',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`tag_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of cm_tag
-- ----------------------------
INSERT INTO `cm_tag` VALUES ('1', 'java', '2020-03-29 17:15:42', '2020-03-29 17:15:42');
INSERT INTO `cm_tag` VALUES ('2', 'php', '2020-03-31 15:02:18', '2020-03-31 15:02:18');
INSERT INTO `cm_tag` VALUES ('3', 'vue', '2020-04-02 15:55:13', '2020-04-02 15:55:13');

-- ----------------------------
-- Table structure for cm_user
-- ----------------------------
DROP TABLE IF EXISTS `cm_user`;
CREATE TABLE `cm_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `user_token` varchar(255) NOT NULL COMMENT '用户token',
  `gitee_id` int(11) DEFAULT NULL COMMENT ' 码云id',
  `user_name` varchar(255) NOT NULL COMMENT '用户名称',
  `user_avatar_url` varchar(255) NOT NULL COMMENT '用户头像',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of cm_user
-- ----------------------------