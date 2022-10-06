/*
 Navicat Premium Data Transfer

 Source Server         : lokal
 Source Server Type    : MySQL
 Source Server Version : 100134
 Source Host           : localhost:3306
 Source Schema         : dpmptgar_dtinvestasi

 Target Server Type    : MySQL
 Target Server Version : 100134
 File Encoding         : 65001

 Date: 06/10/2022 13:14:11
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for data
-- ----------------------------
DROP TABLE IF EXISTS `data`;
CREATE TABLE `data`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `tahun` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `total` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `triwulan` enum('Triwulan 1','Triwulan 2','Triwulan 3','Triwulan 4') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of data
-- ----------------------------
INSERT INTO `data` VALUES (1, '2021', '109956493496', 'Triwulan 1');
INSERT INTO `data` VALUES (2, '2021', '325480923988', 'Triwulan 2');
INSERT INTO `data` VALUES (3, '2021', '199833850739', 'Triwulan 3');
INSERT INTO `data` VALUES (4, '2021', '654812722214', 'Triwulan 4');

SET FOREIGN_KEY_CHECKS = 1;
