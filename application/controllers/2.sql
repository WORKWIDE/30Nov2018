USE [digicomms_Prod1]
GO
/****** Object:  StoredProcedure [dbo].[GetTvGuideViewAllSchoolsLiveEventsByUserId]    Script Date: 6/22/2018 6:59:09 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER PROCEDURE [dbo].[GetTvGuideViewAllSchoolsLiveEventsByUserId]  --0 
   @UserId int  
AS   
   BEGIN  
      SET  NOCOUNT  ON  
  
  	/* get live event collection*/
    SELECT le.ID LiveEventId,le.Name EventName,s.Name SchoolName ,le.EventStatusId , dbo.fnGetEventStartdate(le.ID) EventStartTime ,dbo.fnGetEventEndDate(le.ID) EventEndTime  
    FROM Liveevent le  
	LEFT JOIN School s ON le.SchoolId=s.ID  
	WHERE le.ContentTypeId IN(1,3)
    AND le.EventStatusId IN(2,3)  
    AND le.IsDeleted=0 AND le.IsActive=1  
	
    UNION  
    SELECT le.ID LiveEventId,le.Name EventName,s.Name SchoolName,le.EventStatusId , dbo.fnGetEventStartdate(le.ID) EventStartTime ,dbo.fnGetEventEndDate(le.ID) EventEndTime  
    FROM Liveevent le LEFT JOIN School s ON le.SchoolId=s.ID
    WHERE le.ContentTypeId IN(1,3)  AND le.EventStatusId IN(2,3)  AND le.IsDeleted=0 AND le.IsActive=1; 
	
	/* get game and performer collection*/
	 SELECT leg.LiveEventId,leg.StartTime EventStartTime ,leg.EndTime EventEndTime  
     ,leg.IsEventStarted ,leg.IsEventCompleted  
    FROM Liveevent le  
    JOIN Liveeventgame leg ON le.ID = leg.LiveEventId  
    WHERE le.ContentTypeId IN(1,3) AND le.EventStatusId IN(2,3) AND le.IsDeleted=0 AND le.IsActive=1  
    UNION  
    SELECT lep.LiveEventId, lep.StartTime EventStartTime,lep.EndTime EventEndTime ,
	lep.IsEventStarted ,lep.IsEventCompleted  
    FROM Liveevent le  
    JOIN Liveeventperformer lep ON le.ID = lep.LiveEventId   
    WHERE le.ContentTypeId IN(1,3)  AND le.EventStatusId IN(2,3) AND le.IsDeleted=0 AND le.IsActive=1;  
                 
   END  
  