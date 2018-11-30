USE [digicomms_Prod1]
GO
/****** Object:  StoredProcedure [dbo].[GetTvGuideViewMySchoolsLiveEventsByUserId]    Script Date: 6/22/2018 6:59:14 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER PROCEDURE [dbo].[GetTvGuideViewMySchoolsLiveEventsByUserId] 
   @UserId int
AS 
   BEGIN


      SET  NOCOUNT  ON

            			
				SELECT le.ID LiveEventId,le.Name EventName,0 SchoolId,s.Name SchoolName
				,leg.StartTime EventStartTime
				,leg.EndTime EventEndTime
                ,leg.IsEventStarted
				,leg.IsEventCompleted
				,le.EventStatusId
				FROM Liveevent le
				LEFT JOIN School s ON le.SchoolId=s.ID
				JOIN Liveeventgame leg ON le.ID = leg.LiveEventId  
				INNER JOIN 
					(
            
						SELECT s.ID SchoolId, 1 IsSubscribed
						FROM School  s
						WHERE s.ID IN (SELECT SchoolId FROM Uservouchersubscription WHERE UserId = @UserId And IsActive = 1)

						UNION ALL

						SELECT s.ID SchoolId, 0 IsSubscribed
						FROM School  s
						WHERE s.ID IN (SELECT SchoolId FROM Userschool WHERE UserId = @UserId AND IsFollowed = 1) 
						AND s.ID NOT IN (SELECT s.ID SchoolId FROM School  s WHERE s.ID IN (SELECT SchoolId FROM Uservouchersubscription WHERE UserId = @UserId And IsActive = 1)) 
					)  AS SchoolData ON  le.SchoolId = SchoolData.SchoolId
				WHERE
				le.EventStatusId IN(2,3)
				AND le.IsDeleted=0 AND le.IsActive=1
				AND 1  = CASE WHEN SchoolData.IsSubscribed != 1 THEN CASE WHEN  le.ContentTypeId IN ( 1, 3 ) THEN 1 ELSE 0 END
                          ELSE 1 END

                UNION

                SELECT le.ID LiveEventId,le.Name EventName,0 SchoolId,s.Name SchoolName
				,lep.StartTime EventStartTime
				,lep.EndTime EventEndTime
                ,lep.IsEventStarted
				,lep.IsEventCompleted
				,le.EventStatusId
				FROM Liveevent le
				LEFT JOIN School s ON le.SchoolId=s.ID
				JOIN Liveeventperformer lep ON le.ID = lep.LiveEventId 
				INNER JOIN 
					(
            
						SELECT s.ID SchoolId, 1 IsSubscribed
						FROM School  s
						WHERE s.ID IN (SELECT SchoolId FROM Uservouchersubscription WHERE UserId = @UserId And IsActive = 1)

						UNION ALL

						SELECT s.ID SchoolId, 0 IsSubscribed
						FROM School  s
						WHERE s.ID IN (SELECT SchoolId FROM Userschool WHERE UserId = @UserId AND IsFollowed = 1) 
						AND s.ID NOT IN (SELECT s.ID SchoolId FROM School  s WHERE s.ID IN (SELECT SchoolId FROM Uservouchersubscription WHERE UserId = @UserId And IsActive = 1)) 
					)  AS SchoolData ON  le.SchoolId = SchoolData.SchoolId
				WHERE 
				le.EventStatusId IN(2,3)
				AND le.IsDeleted=0 AND le.IsActive=1
				AND 1  = CASE WHEN SchoolData.IsSubscribed != 1 THEN CASE WHEN  le.ContentTypeId IN ( 1, 3 ) THEN 1 ELSE 0 END
                          ELSE 1 END
   END


