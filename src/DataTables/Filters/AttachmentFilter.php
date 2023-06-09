<?php
/*
 * This file is part of Part-DB (https://github.com/Part-DB/Part-DB-symfony).
 *
 *  Copyright (C) 2019 - 2022 Jan Böhmer (https://github.com/jbtronics)
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU Affero General Public License as published
 *  by the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU Affero General Public License for more details.
 *
 *  You should have received a copy of the GNU Affero General Public License
 *  along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

namespace App\DataTables\Filters;

use App\DataTables\Filters\Constraints\BooleanConstraint;
use App\DataTables\Filters\Constraints\DateTimeConstraint;
use App\DataTables\Filters\Constraints\EntityConstraint;
use App\DataTables\Filters\Constraints\InstanceOfConstraint;
use App\DataTables\Filters\Constraints\IntConstraint;
use App\DataTables\Filters\Constraints\NumberConstraint;
use App\DataTables\Filters\Constraints\TextConstraint;
use App\Entity\Attachments\AttachmentType;
use App\Services\Trees\NodesListBuilder;
use Doctrine\ORM\QueryBuilder;

class AttachmentFilter implements FilterInterface
{
    use CompoundFilterTrait;

    protected NumberConstraint $dbId;
    protected InstanceOfConstraint $targetType;
    protected TextConstraint $name;
    protected EntityConstraint $attachmentType;
    protected BooleanConstraint $showInTable;
    protected DateTimeConstraint $lastModified;
    protected DateTimeConstraint $addedDate;


    public function __construct(NodesListBuilder $nodesListBuilder)
    {
        $this->dbId = new IntConstraint('attachment.id');
        $this->name = new TextConstraint('attachment.name');
        $this->targetType = new InstanceOfConstraint('attachment');
        $this->attachmentType = new EntityConstraint($nodesListBuilder, AttachmentType::class, 'attachment.attachment_type');
        $this->lastModified = new DateTimeConstraint('attachment.lastModified');
        $this->addedDate = new DateTimeConstraint('attachment.addedDate');
        $this->showInTable = new BooleanConstraint('attachment.show_in_table');
    }

    public function apply(QueryBuilder $queryBuilder): void
    {
        $this->applyAllChildFilters($queryBuilder);
    }

    /**
     * @return NumberConstraint
     */
    public function getDbId(): NumberConstraint
    {
        return $this->dbId;
    }

    /**
     * @return TextConstraint
     */
    public function getName(): TextConstraint
    {
        return $this->name;
    }

    /**
     * @return DateTimeConstraint
     */
    public function getLastModified(): DateTimeConstraint
    {
        return $this->lastModified;
    }

    /**
     * @return DateTimeConstraint
     */
    public function getAddedDate(): DateTimeConstraint
    {
        return $this->addedDate;
    }


    /**
     * @return BooleanConstraint
     */
    public function getShowInTable(): BooleanConstraint
    {
        return $this->showInTable;
    }


    /**
     * @return EntityConstraint
     */
    public function getAttachmentType(): EntityConstraint
    {
        return $this->attachmentType;
    }

    /**
     * @return InstanceOfConstraint
     */
    public function getTargetType(): InstanceOfConstraint
    {
        return $this->targetType;
    }






}