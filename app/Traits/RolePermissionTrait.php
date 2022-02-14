<?php

namespace App\Traits;

trait RolePermissionTrait
{
    public $rptAdmin = 1;
    public $rptMember = 2;
    public $rptStudent = 3;
    public $rptSchool = 4;
    public $rptEditor = 5;
    public $rptCreator = 6;

    public function frontendRoleIds()
    {
        return [$this->rptSchool, $this->rptStudent, $this->rptMember];
    }

    public function isAdminRole()
    {
        return $this->hasAnyRole($this->rptAdmin);
    }

    public function isEditorRole()
    {
        return $this->hasAnyRole($this->rptEditor);
    }

    public function isMemberRole()
    {
        return $this->hasAnyRole($this->rptMember);
    }

    public function isStudentRole()
    {
        return $this->hasAnyRole($this->rptStudent);
    }
    public function isSchoolRole()
    {
        return $this->hasAnyRole($this->rptSchool);
    }
    public function isCreatorRole()
    {
        return $this->hasAnyRole($this->rptCreator);
    }

    public function isBackendRoles()
    {
        return $this->isAdminRole() || $this->isEditorRole() || $this->isCreatorRole();
    }

    public function isFrontendRoles()
    {
        return $this->isStudentRole() || $this->isSchoolRole() || $this->isMemberRole();
    }

    protected function canError($id)
    {
        try {
            return $this->hasPermissionTo($id);
        } catch (\Throwable $e) {
            return false;
        }
    }

    public function canUserList()
    {
        return $this->canError(1);
    }
    public function canUserCreate()
    {
        return $this->canError(2);
    }
    public function canUserUpdate()
    {
        return $this->canError(3);
    }
    public function canUserDelete()
    {
        return $this->canError(4);
    }
    public function canUserShow()
    {
        return $this->canError(5);
    }
    public function canUserForceDelete()
    {
        return $this->canError(6);
    }
    public function canUserRestore()
    {
        return $this->canError(7);
    }

    public function canContestList()
    {
        return $this->canError(21);
    }
    public function canContestCreate()
    {
        return $this->canError(22);
    }
    public function canContestUpdate()
    {
        return $this->canError(23);
    }
    public function canContestDelete()
    {
        return $this->canError(24);
    }
    public function canContestShow()
    {
        return $this->canError(25);
    }
    public function canContestForceDelete()
    {
        return $this->canError(26);
    }
    public function canContestRestore()
    {
        return $this->canError(27);
    }
    public function canContestApprove()
    {
        return $this->canError(28);
    }
    public function canContestReject()
    {
        return $this->canError(29);
    }

    public function canQuestionList()
    {
        return $this->canError(41);
    }
    public function canQuestionCreate()
    {
        return $this->canError(42);
    }
    public function canQuestionUpdate()
    {
        return $this->canError(43);
    }
    public function canQuestionDelete()
    {
        return $this->canError(44);
    }
    public function canQuestionShow()
    {
        return $this->canError(45);
    }
    public function canQuestionForceDelete()
    {
        return $this->canError(46);
    }
    public function canQuestionRestore()
    {
        return $this->canError(47);
    }
    public function canQuestionApprove()
    {
        return $this->canError(48);
    }
    public function canQuestionReject()
    {
        return $this->canError(49);
    }

    public function canAnswerList()
    {
        return $this->canError(61);
    }
    public function canAnswerCreate()
    {
        return $this->canError(62);
    }
    public function canAnswerUpdate()
    {
        return $this->canError(63);
    }
    public function canAnswerDelete()
    {
        return $this->canError(64);
    }
    public function canAnswerShow()
    {
        return $this->canError(65);
    }
    public function canAnswerForceDelete()
    {
        return $this->canError(66);
    }
    public function canAnswerRestore()
    {
        return $this->canError(67);
    }
    public function canAnswerApprove()
    {
        return $this->canError(68);
    }
    public function canAnswerReject()
    {
        return $this->canError(69);
    }

    public function canLevelList()
    {
        return $this->canError(81);
    }
    public function canLevelCreate()
    {
        return $this->canError(82);
    }
    public function canLevelUpdate()
    {
        return $this->canError(83);
    }
    public function canLevelDelete()
    {
        return $this->canError(84);
    }
    public function canLevelShow()
    {
        return $this->canError(85);
    }
    public function canLevelForceDelete()
    {
        return $this->canError(86);
    }
    public function canLevelRestore()
    {
        return $this->canError(87);
    }

    //WORK SHOP
    public function canWorkshopList()
    {
        return $this->canError(101);
    }
    public function canWorkshopCreate()
    {
        return $this->canError(102);
    }
    public function canWorkshopUpdate()
    {
        return $this->canError(103);
    }
    public function canWorkshopDelete()
    {
        return $this->canError(104);
    }
    public function canWorkshopShow()
    {
        return $this->canError(105);
    }
    public function canWorkshopForceDelete()
    {
        return $this->canError(106);
    }
    public function canWorkshopRestore()
    {
        return $this->canError(107);
    }
    public function canWorkshopApprove()
    {
        return $this->canError(108);
    }
    public function canWorkshopReject()
    {
        return $this->canError(109);
    }

    //WORK DOCUMENT
    public function canDocumentList()
    {
        return $this->canError(121);
    }
    public function canDocumentCreate()
    {
        return $this->canError(122);
    }
    public function canDocumentUpdate()
    {
        return $this->canError(123);
    }
    public function canDocumentDelete()
    {
        return $this->canError(124);
    }
    public function canDocumentShow()
    {
        return $this->canError(125);
    }
    public function canDocumentForceDelete()
    {
        return $this->canError(126);
    }
    public function canDocumentRestore()
    {
        return $this->canError(127);
    }
    public function canDocumentApprove()
    {
        return $this->canError(128);
    }
    public function canDocumentReject()
    {
        return $this->canError(129);
    }

    public function canStudentList()
    {
        return $this->canError(141);
    }
    public function canStudentCreate()
    {
        return $this->canError(142);
    }
    public function canStudentUpdate()
    {
        return $this->canError(143);
    }
    public function canStudentDelete()
    {
        return $this->canError(144);
    }
    public function canStudentShow()
    {
        return $this->canError(145);
    }
    public function canStudentForceDelete()
    {
        return $this->canError(146);
    }
    public function canStudentRestore()
    {
        return $this->canError(147);
    }

    public function canRegisteredContestList()
    {
        return $this->canError(161);
    }
    public function canRegisteredContestCreate()
    {
        return $this->canError(162);
    }
    public function canRegisteredContestUpdate()
    {
        return $this->canError(163);
    }
    public function canRegisteredContestDelete()
    {
        return $this->canError(164);
    }
    public function canRegisteredContestShow()
    {
        return $this->canError(165);
    }
    public function canRegisteredContestForceDelete()
    {
        return $this->canError(166);
    }
    public function canRegisteredContestRestore()
    {
        return $this->canError(167);
    }

    public function canCategoryList()
    {
        return $this->canError(181);
    }
    public function canCategoryCreate()
    {
        return $this->canError(182);
    }
    public function canCategoryUpdate()
    {
        return $this->canError(183);
    }
    public function canCategoryDelete()
    {
        return $this->canError(184);
    }
    public function canCategoryShow()
    {
        return $this->canError(185);
    }
    public function canCategoryForceDelete()
    {
        return $this->canError(186);
    }
    public function canCategoryRestore()
    {
        return $this->canError(187);
    }

    //FAQ
    public function canFaqList()
    {
        return $this->canError(201);
    }
    public function canFaqCreate()
    {
        return $this->canError(202);
    }
    public function canFaqUpdate()
    {
        return $this->canError(203);
    }
    public function canFaqDelete()
    {
        return $this->canError(204);
    }
    public function canFaqShow()
    {
        return $this->canError(205);
    }
    public function canFaqForceDelete()
    {
        return $this->canError(206);
    }
    public function canFaqRestore()
    {
        return $this->canError(207);
    }

    //NEWS
    public function canNewsList()
    {
        return $this->canError(221);
    }
    public function canNewsCreate()
    {
        return $this->canError(222);
    }
    public function canNewsUpdate()
    {
        return $this->canError(223);
    }
    public function canNewsDelete()
    {
        return $this->canError(224);
    }
    public function canNewsShow()
    {
        return $this->canError(225);
    }
    public function canNewsForceDelete()
    {
        return $this->canError(226);
    }
    public function canNewsRestore()
    {
        return $this->canError(227);
    }
    public function canNewsApprove()
    {
        return $this->canError(228);
    }
    public function canNewsReject()
    {
        return $this->canError(229);
    }
}
