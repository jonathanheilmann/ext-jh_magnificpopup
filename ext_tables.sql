#
# Table structure for table 'tt_content'
#
CREATE TABLE tt_content (
	tx_jhmagnificpopup_irre_parentid int(11) DEFAULT '0' NOT NULL,
	KEY jh_magnificpopup (tx_jhmagnificpopup_irre_parentid,sorting)
);

